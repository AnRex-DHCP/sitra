<?php

namespace App\Livewire\Security\Permissions;

use App\Models\CustomPermission as Permission;
use App\Traits\HandlesValidationExceptions;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Application;
use App\Models\CustomPermission;
use App\Models\PermissionModule;
use App\Livewire\Forms\PermissionForm;
use App\Exceptions\PermissionValidationException; // Añade esta línea

class PermissionFormComponent extends Component
{
    use HandlesValidationExceptions;
    public PermissionForm $form;
    public $applications = [];
    public $modules = [];
    public $mode = 'create'; // create, edit, show

    public function mount($id=null, $mode = 'create')
    {
        $this->mode = $mode;
        $this->applications = Application::pluck('name', 'id');

        if($id!=null) {
            $this->form->setPermission($id);
            $this->loadModules();
        }

    }

    public function updatedFormApplicationId($value)
    {
        if ($this->mode !== 'show') {
            $this->loadModules();
            $this->form->permission_module_id = ''; // Reset módulo seleccionado
        }
    }

    private function loadModules()
    {
        if ($this->form->application_id) {
            $this->modules = PermissionModule::where('application_id', $this->form->application_id)
                                          ->pluck('name', 'id');
        } else {
            $this->modules = [];
        }
    }

    #[On('submit-form')]
    public function save()
    {
        if ($this->mode === 'show') {
            return;
        }

        try {
            if ($this->mode === 'edit') {
                $this->form->update();
                $message = '¡Permiso actualizado exitosamente!';
            } else {
                $this->form->store();
                $message = '¡Permiso creado exitosamente!';
            }

        session()->flash('success', $message);
        return redirect()->route('permissions');

        } catch (PermissionValidationException $e) {
                $this->handleValidationException($e);
            }

    }

    public function render()
    {
        return view('livewire.security.permissions.permission-form');
    }
}
