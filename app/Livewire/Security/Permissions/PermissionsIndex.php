<?php

namespace App\Livewire\Security\Permissions;

use App\Models\Permission;
use App\Models\PermissionModule;
use App\Models\ViewPermission;
use App\Traits\WithBulkActions;
use Livewire\Component;
use Livewire\WithPagination;
class PermissionsIndex extends Component
{
    use WithPagination, withBulkActions;
    public string $moduleName = 'Permisos';
    public $selectedItems = [];

    public function render()
    {
        $query = ViewPermission::query()->orderBy('id', 'desc');

        return view('livewire.security.permissions.permissions-index', [
            'tableData'=>[
                'query' => $query,
                'columns' => [
                    /*'id' => ['label'=>'ID', 'width' => '70px', 'align' => 'center'],*/
                    'application_name' => ['label'=> 'Aplicación', 'width' => '200px'],
                    'module_name' => ['label'=> 'Módulo', 'width' => '200px'],
                    'name' => ['label'=> 'Permiso'],
                    'created_at' => ['label'=> 'Fecha Creación', 'width' => '200px']
                ],
                'actions' => [
                    [
                        'name' => 'show',
                        'label' => '',
                        'icon' => ' ri-eye-fill',
                        'class' => 'btn-info btn-sm',
                        'route' => 'permissions.show',
                        'parameters' => ['id']
                    ],
                    [
                        'name' => 'edit',
                        'label' => '',
                        'icon' => 'ri-pencil-fill',
                        'class' => 'btn-warning btn-sm',
                        'route' => 'permissions.edit',
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
                'selectColumns' => ['id', 'application_name', 'module_name', 'name', 'guard_name', 'created_at'],
            ],
            'tableStyle' => 'bootstrap'
        ]);
    }

    protected function getModel(): string
    {
        return Permission::class;
    }

}
