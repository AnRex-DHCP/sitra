<?php

namespace App\Livewire\Maintenance\Catalogs;

use App\Models\Application;
use App\Models\PermissionModule;
use App\Traits\WithBulkActions;
use Livewire\Component;
use Livewire\WithPagination;

class ModulesIndex extends Component
{
    use WithPagination, WithBulkActions;
    public string $moduleName = 'Módulos';
    public $selectedItems = [];

    public function render()
    {
        $query = PermissionModule::query()->orderBy('id', 'desc');
        return view('livewire.maintenance.catalogs.modules-index', [
            'tableData'=>[
                'query' => $query,
                'columns' => [
                    /*'id' => ['label'=>'ID', 'width' => '70px', 'align' => 'center'],*/
                    'application.name' => ['label'=> 'Aplicación', 'width' => '300px'],
                    'name' => ['label'=> 'Módulo'],
                    'created_at' => ['label'=> 'Fecha Creación', 'width' => '200px']
                ],
                'actions' => [
                    [
                        'name' => 'show',
                        'label' => '',
                        'icon' => ' ri-eye-fill',
                        'class' => 'btn-info btn-sm',
                        'route' => 'modules.show',
                        'parameters' => ['id']
                    ],
                    [
                        'name' => 'edit',
                        'label' => '',
                        'icon' => 'ri-pencil-fill',
                        'class' => 'btn-warning btn-sm',
                        'route' => 'modules.edit',
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
                'searchColumns' => ['name',  'application.name'],
                'selectColumns' => ['permission_modules.*'],
                'withRelations' => ['application'],

            ],
            'tableStyle' => 'bootstrap'
        ]);
    }

    protected function getModel(): string
    {
        return PermissionModule::class;
    }
}
