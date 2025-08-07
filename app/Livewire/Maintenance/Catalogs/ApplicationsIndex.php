<?php

namespace App\Livewire\Maintenance\Catalogs;

use App\Models\Application;
use App\Traits\WithBulkActions;
use Livewire\Component;
use Livewire\WithPagination;

class ApplicationsIndex extends Component
{
    use WithPagination, WithBulkActions;
    public string $moduleName = 'Permisos';
    public $selectedItems = [];

    public function render()
    {
        $query = Application::query()->orderBy('id', 'desc');
        return view('livewire.maintenance.catalogs.applications-index', [
            'tableData'=>[
                'query' => $query,
                'columns' => [
                    /*'id' => ['label'=>'ID', 'width' => '70px', 'align' => 'center'],*/
                    'name' => ['label'=> 'Aplicación'],
                    'created_at' => ['label'=> 'Fecha Creación', 'width' => '200px']
                ],
                'actions' => [
                    [
                        'name' => 'show',
                        'label' => '',
                        'icon' => ' ri-eye-fill',
                        'class' => 'btn-info btn-sm',
                        'route' => 'applications.show',
                        'parameters' => ['id']
                    ],
                    [
                        'name' => 'edit',
                        'label' => '',
                        'icon' => 'ri-pencil-fill',
                        'class' => 'btn-warning btn-sm',
                        'route' => 'applications.edit',
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
                'selectColumns' => ['id', 'name', 'created_at'],
            ],
            'tableStyle' => 'bootstrap'
        ]);
    }

    protected function getModel(): string
    {
        return Application::class;
    }

}
