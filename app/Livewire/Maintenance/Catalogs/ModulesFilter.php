<?php

namespace App\Livewire\Maintenance\Catalogs;

use App\Models\Application;
use App\Models\PermissionModule;
use Livewire\Component;
use Livewire\WithPagination;

class ModulesFilter extends Component
{
    use WithPagination;

    public $filters = [
        'name' => '',
        'application_id' => ''
    ];

    protected $queryString = ['filters'];

    public $applications = [];
    public $moduleIdentifier;

    public function mount($moduleIdentifier = 'modules')
    {
        $this->moduleIdentifier = $moduleIdentifier;
        $this->applications = Application::all();

        // Recuperar filtros guardados
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
            'application_id' => ''
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
        return view('livewire.maintenance.catalogs.modules-filter');
    }
}
