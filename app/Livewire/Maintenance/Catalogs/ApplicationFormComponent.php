<?php

namespace App\Livewire\Maintenance\Catalogs;

use App\Exceptions\PermissionValidationException;
use App\Livewire\Forms\ApplicationForm;
use App\Models\Application;
use App\Models\PermissionModule;
use App\Traits\HandlesValidationExceptions;
use Livewire\Attributes\On;
use Livewire\Component;

class ApplicationFormComponent extends Component
{
    use HandlesValidationExceptions;
    public ApplicationForm $form;
    public $mode = 'create';

    public function render()
    {
        return view('livewire.maintenance.catalogs.application-form-component');
    }

    public function mount($id=null, $mode = 'create')
    {
        $this->mode = $mode;
        if($id!=null) {
            $this->form->setApplication($id);
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
                $message = '¡Aplicación actualizada exitosamente!';
            } else {
                $this->form->store();
                $message = '¡Aplicación creada exitosamente!';
            }

            session()->flash('success', $message);
            return redirect()->route('applications');

        } catch (PermissionValidationException $e) {
            $this->handleValidationException($e);
        }
    }
}
