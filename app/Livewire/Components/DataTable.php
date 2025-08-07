<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;
// ... otros imports

use App\Traits\WithCustomPagination;
use App\Traits\WithTableStyle;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class DataTable extends Component
{
    use WithPagination;
    use WithCustomPagination;
    use WithTableStyle;

    public $filters = [];
    protected $listeners = ['filtersUpdated' => 'updateFilters'];

    public string $moduleName = '';
    public $modelClass;
    public $baseQuery = [];

    public $columns;
    public $actions;
    public $searchColumns = [];
    public $perPage = 10;
    public $search = '';
    public $sortField = 'article_id';
    public $sortDirection = 'desc';
    public $selectColumns = ['*'];
    public $withRelations = [];
    public $moduleIdentifier;
    public $selectedItems = [];
    public $selectAll = false;
    public $searchPlaceholder = 'Buscar...';

    public function updateFilters($newFilters)
    {
        $this->filters = $newFilters;
    }

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public function mount($query, $columns, $actions = [], $searchColumns = [], $selectColumns = ['*'], $withRelations = [], $tableStyle = 'bootstrap', $tableView = null, $moduleName = '', $moduleIdentifier = null, $searchPlaceholder = 'Buscar...')
    {
        $this->moduleName = $moduleName;
        $this->moduleIdentifier = $moduleIdentifier ?? strtolower(class_basename($query->getModel()));
        // Guardar la clase del modelo y cualquier condición base
        $this->modelClass = get_class($query->getModel());
        $this->baseQuery = $query->getQuery()->wheres ?? [];

        $this->columns = $columns;
        $this->actions = $actions;
        $this->searchColumns = $searchColumns;
        $this->selectColumns = $selectColumns;
        $this->withRelations = $withRelations;
        $this->searchPlaceholder = $searchPlaceholder ?? 'Buscar...';
        // Recuperar estado guardado
        $this->loadSavedState();

        $this->setTableStyle($tableStyle);
        if ($tableView) {
            $this->setTableView($tableView);
        }

        // --- NUEVO: aseguramos que el campo de ordenamiento exista en la consulta
        $validSortFields = array_keys($columns); // Solo los campos definidos en columns
        if (!in_array($this->sortField, $validSortFields)) {
        $this->sortField = 'created_at'; // o el que prefieras como default
        }

    }

    private function loadSavedState()
    {
        // Recuperar estado de la tabla
        $savedState = session("{$this->moduleIdentifier}_table_state");
        if ($savedState) {
            $this->search = $savedState['search'] ?? '';
            $this->sortField = $savedState['sortField'] ?? 'created_at';
            $this->sortDirection = $savedState['sortDirection'] ?? 'desc';
            $this->perPage = $savedState['perPage'] ?? 10;
        }

        // Recuperar filtros
        $savedFilters = session("{$this->moduleIdentifier}_filters");
        if ($savedFilters) {
            $this->filters = $savedFilters;
        }
    }

    private function saveState()
    {
        session([
            "{$this->moduleIdentifier}_table_state" => [
                'search' => $this->search,
                'sortField' => $this->sortField,
                'sortDirection' => $this->sortDirection,
                'perPage' => $this->perPage,
            ]
        ]);
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'sortField', 'sortDirection', 'perPage'])) {
            $this->saveState();
        }
    }

    public function getDefaultTableConfig(): array
    {
        return [
            'table_class' => 'table align-middle table-hover',
            'thead_class' => 'table-light',
            'tbody_class' => '',
            'tr_class' => '',
            'th_class' => 'sort',
            'td_class' => '',
            'pagination_class' => 'mt-3',
            'search_class' => 'form-control search bg-light border-light',
            'per_page_class' => 'form-select bg-light border-light',
            'wrapper_class' => 'table-responsive table-card',
            'action_button_class' => 'btn btn-sm',
            'action_wrapper_class' => 'd-flex gap-2',
        ];
    }

    protected function getBaseQuery(): Builder
    {
        // Reconstruir la consulta base
        $query = app($this->modelClass)->query();

        // Aplicar condiciones base si existen
        if (!empty($this->baseQuery)) {
            foreach ($this->baseQuery as $where) {
                if (isset($where['column']) && isset($where['value'])) {
                    $query->where($where['column'], $where['operator'] ?? '=', $where['value']);
                }
            }
        }
        return $query;
    }

    public function getDataQuery()
    {
        $query = $this->getBaseQuery();

        // Agregar relaciones si existen
        if (!empty($this->withRelations)) {
            $query =$query->with($this->withRelations);
        }

        // Aplicar filtros dinámicamente
        $this->applyDynamicFilters($query);

        // Aplicar búsqueda si existe
        if ($this->search && !empty($this->searchColumns)) {
            $query->where(function (Builder $query) {
                foreach ($this->searchColumns as $column) {
                    if (str_contains($column, '.')) {
                        [$relation, $field] = explode('.', $column);
                        $query->orWhereHas($relation, function ($q) use ($field) {
                            $q->where($field, 'like', '%' . $this->search . '%');
                        });
                    } else {
                        $query->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                }
            });
        }

        return $query->orderBy($this->sortField, $this->sortDirection)
            ->select($this->selectColumns);
    }

    protected function applyDynamicFilters($query)
    {
        foreach ($this->filters as $field => $value) {
            if (isset($value) && $value !== '') {
                // Manejo especial para fechas
                if ($field === 'created_at') {
                    $this->applyDateFilter($query, $value);
                    continue;
                }

                // Determinar si el campo debe usar LIKE
                if (in_array($field, ['name', 'guard_name', 'description', 'email'])) {
                    $query->where($field, 'like', '%' . $value . '%');
                } else {
                    $query->where($field, $value);
                }
            }
        }
    }

    protected function applyDateFilter($query, $value)
    {
        $dates = explode(' to ', $value);
        if (count($dates) == 2) {
            $query->whereBetween('created_at', [
                $dates[0] . ' 00:00:00',
                $dates[1] . ' 23:59:59'
            ]);
        }
    }


    public function sortBy($field)
    {
          $sortableFields = ['name', 'created_at', 'id'];
    if (in_array($field, $sortableFields)) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->saveState();
    }
}

public function executeAction($route, $params = [])
{
    if ($route === 'delete') {
        // Disparamos un evento Livewire, que capturará el Livewire.on(...) en tu JS
        $this->dispatch('recordDeletedConfirm', $params['id']);
    } else {
        return redirect()->route($route, $params);
    }
}


    // Agregar estos métodos
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = $this->getDataQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedItems = [];
        }
        // Emitir evento con los items seleccionados
        $this->dispatch('selectedItemsChanged', selectedItems: $this->selectedItems);
    }

    public function updatedSelectedItems()
    {
        $this->selectAll = count($this->selectedItems) === $this->getDataQuery()->count();
        // Emitir evento con los items seleccionados
        $this->dispatch('selectedItemsChanged', selectedItems: $this->selectedItems);
    }

    #[On('filtersUpdated')]
    public function handleFiltersUpdated($filters)
    {
        $this->filters = $filters;
    }

    #[On('refreshTable')]
    public function refresh()
    {
        // Este método forzará la re-renderización del componente
        $this->resetPage();
        $this->resetSelection();
    }

    #[On('resetSelection')]
    public function resetSelection()
    {
        $this->selectedItems = [];
        $this->selectAll = false;
        $this->dispatch('selectedItemsChanged', selectedItems: []);
    }


    public function render()
    {
        $data = $this->getDataQuery()->paginate($this->perPage);

        //dd($this->getTableView());
        return view($this->getTableView(), [
            'data' => $data,
        ]);
    }
} 