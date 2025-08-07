<?php

namespace App\Livewire\Security\Roles;

use App\Models\Permission;
use App\Models\Role;
use App\Models\ViewPermission;
use App\Traits\WithBulkActions;
use Livewire\Component;
use Livewire\WithPagination;

class RolesIndex extends Component
{
    use WithPagination, withBulkActions;
    public string $moduleName = 'Roles';
    public $selectedItems = [];

    public function render()
    {
        $query = Role::query()->orderBy('id', 'desc');
        return view('livewire.security.roles.roles-index', [
            'tableData'=>[
                'query' => $query,
                'columns' => [
                    'name' => ['label'=> 'Rol'],
                    'created_at' => ['label'=> 'Fecha Creación', 'width' => '200px']
                ],
                'actions' => [
                    [
                        'name' => 'show',
                        'label' => '',
                        'icon' => ' ri-eye-fill',
                        'class' => 'btn-info btn-sm',
                        'route' => 'roles.show',
                        'parameters' => ['id']
                    ],
                    [
                        'name' => 'edit',
                        'label' => '',
                        'icon' => 'ri-pencil-fill',
                        'class' => 'btn-warning btn-sm',
                        'route' => 'roles.edit',
                        'parameters' => ['id']
                    ],
                    [
                        'name' => 'delete',
                        'label' => '',
                        'icon' => 'ri-delete-bin-fill',
                        'class' => 'btn-danger btn-sm',
                        'route' => 'delete',
                        'parameters' => ['id'],
                        'confirm' => '¿Estás seguro que deseas eliminar este permiso?'
                    ],
                ],
                'searchColumns' => ['name'],
                'selectColumns' => ['id', 'name', 'guard_name', 'created_at'],
            ],
            'tableStyle' => 'bootstrap'
        ]);
    }

    protected function getModel(): string
    {
        return Role::class;
    }
}
