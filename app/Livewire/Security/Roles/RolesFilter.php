<?php

namespace App\Livewire\Security\Roles;

use Livewire\Component;
use Livewire\WithPagination;

class RolesFilter extends Component
{
    use WithPagination;

    public $filters = [
        'name' => ''
    ];

    protected $queryString = ['filters'];
    public $moduleIdentifier;

    public function mount($moduleIdentifier = 'permissions')
    {
        $this->moduleIdentifier = $moduleIdentifier;
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
            'module_id' => ''
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
        return view('livewire.security.roles.roles-filter');
    }
}
