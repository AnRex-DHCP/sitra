<?php

namespace App\Livewire\Maintenance\Catalogs\Areas;

use App\Models\Area;
use Livewire\Component;

class AreasFilter extends Component
{
    public $filters = [
        'name' => '',
        'parent_id' => ''
    ];

    protected $queryString = ['filters'];
    public $areasList = [];
    public $moduleIdentifier;

    public function mount($moduleIdentifier = 'areas')
    {
        $this->moduleIdentifier = $moduleIdentifier;
        // Mostrar solo áreas principales en el filtro de áreas padre
        $this->areasList = Area::whereNull('parent_id')->orderBy('name')->get();

        $savedFilters = session("{$this->moduleIdentifier}_filters");
        if ($savedFilters) {
            $this->filters = $savedFilters;
            $this->dispatch('filtersUpdated', $this->filters);
        }
    }

    public function updatedFilters()
    {
        $this->saveFilters();
        $this->dispatch('filtersUpdated', $this->filters);
    }

    public function applyFilters()
    {
        $this->saveFilters();
        $this->dispatch('filtersUpdated', $this->filters);
        $this->dispatch('closeOffcanvas');
    }

    public function resetFilters()
    {
        $this->filters = [
            'name' => '',
            'parent_id' => ''
        ];
        $this->saveFilters();
        $this->dispatch('filtersUpdated', $this->filters);
        $this->dispatch('closeOffcanvas');
    }

    private function saveFilters()
    {
        session(["{$this->moduleIdentifier}_filters" => $this->filters]);
    }

    public function render()
    {
        return view('livewire.maintenance.catalogs.areas.areas-filter');
    }
}