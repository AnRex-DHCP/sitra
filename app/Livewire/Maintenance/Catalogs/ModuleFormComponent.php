<?php

namespace App\Livewire\Maintenance\Catalogs;

use App\Exceptions\PermissionValidationException;
use App\Livewire\Forms\ModuleForm;
use App\Models\Application;
use App\Traits\HandlesValidationExceptions;
use Livewire\Attributes\On;
use Livewire\Component;

class ModuleFormComponent extends Component
{
    use HandlesValidationExceptions;
    public ModuleForm $form;
    public $mode = 'create';
    public $applications = [];

    public function render()
    {
        return view('livewire.maintenance.catalogs.module-form-component');
    }

    public function mount($id=null, $mode = 'create')
    {
        $this->mode = $mode;
        $this->applications = Application::pluck('name', 'id');
        if($id!=null) {
            $this->form->setModule($id);
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
                $message = '¡Módulo actualizada exitosamente!';
            } else {
                $this->form->store();
                $message = '¡Módulo creada exitosamente!';
            }

            session()->flash('success', $message);
            return redirect()->route('modules');

        } catch (PermissionValidationException $e) {
            $this->handleValidationException($e);
        }
    }
}
