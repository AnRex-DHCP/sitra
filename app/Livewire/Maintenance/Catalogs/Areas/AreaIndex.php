<?php

namespace App\Livewire\Maintenance\Catalogs\Areas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Area;

class AreaIndex extends Component
{
    use WithPagination;

    public $filters = [
        'name' => '',
        'parent_id' => ''
    ];

    protected $listeners = [
        'recordDeleted' => 'delete',
        'filtersUpdated' => 'applyFilters',
    ];

    public function applyFilters($filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    public function delete($id)
    {
        Area::findOrFail($id)->delete();
        $this->dispatch('refreshTable');
    }

    public function render()
    {
        $ids = null;

        if (!empty($this->filters['parent_id'])) {
            // Cargar hasta nietos
            $parent = Area::with('children.children.children.children.children')->find($this->filters['parent_id']);
            if ($parent) {
                $ids = $parent->getAllDescendantsAndSelfIds();
                // Para que el orden sea jerárquico, usamos FIELD
            }
        }

        $query = Area::query()->with('parent.parent');

        if ($ids) {
            // Ordenar según jerarquía seleccionada
            $order = implode(',', $ids);
            $query->whereIn('id', $ids)
                  ->orderByRaw("FIELD(id, $order)");
        } else {
            $query->orderBy('name');
        }

        if ($this->filters['name']) {
            $query->where('name', 'like', '%' . $this->filters['name'] . '%');
        }

        // Puedes comentar esta línea para debug
        // $areas = $query->get();
        // dd(['ids' => $ids, 'areas' => $areas->pluck('name', 'id')]);

        // Sin paginación (debug)
        $data = $query->get();

        return view('livewire.maintenance.catalogs.areas.index', [
            'data' => $data, // OJO: aquí ya mandamos la colección, no el query
        ]);
    }
}
