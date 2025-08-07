<?php

namespace App\Livewire\Security\Roles;

use App\Models\Application;
use App\Models\CustomPermission;
use App\Models\PermissionModule;
use App\Exceptions\PermissionValidationException;
use App\Livewire\Forms\RoleForm;
use App\Traits\HandlesValidationExceptions;
use Livewire\Attributes\On;
use Livewire\Component;

class RoleFormComponent extends Component
{
    use HandlesValidationExceptions;

    public RoleForm $form;
    public $mode = 'create';
    public $groupedPermissions = [];
    public $selectedPermissions = [];

    public function mount($id = null, $mode = 'create')
    {
        $this->mode = $mode;
        if ($id != null) {
            $this->form->setRole($id);
            $this->selectedPermissions = $this->form->role->permissions->pluck('id')->toArray();
        }

        $this->loadGroupedPermissions();
    }

    #[On('submit-form')]
    public function save()
    {
        return match($this->mode) {
            'show' => null,
            'edit' => $this->saveEditMode(),
            'create' => $this->saveCreateMode(),
            default => throw new \InvalidArgumentException("Modo no válido: {$this->mode}")
        };
    }


    private function saveEditMode()
    {
        try {
            $this->form->update();
            session()->flash('success', '¡Rol actualizado exitosamente!');
            return redirect()->route('roles');
        } catch (PermissionValidationException $e) {
            $this->handleValidationException($e);
        }
    }

    private function saveCreateMode()
    {
        try {
            $this->form->store();
            session()->flash('success', '¡Rol creado exitosamente!');
            return redirect()->route('roles');
        } catch (PermissionValidationException $e) {
            $this->handleValidationException($e);
        }
    }

    private function loadGroupedPermissions()
    {
        $applications = Application::with(['modules.permissions'])->get();

        foreach ($applications as $application) {
            $this->groupedPermissions[$application->id] = [
                'name' => $application->name,
                'modules' => []
            ];

            foreach ($application->modules as $module) {
                $this->groupedPermissions[$application->id]['modules'][$module->id] = [
                    'name' => $module->name,
                    'permissions' => $module->permissions->map(function($permission) {
                        return [
                            'id' => $permission->id,
                            'name' => $permission->name,
                            'description' => $permission->description
                        ];
                    })->toArray()
                ];
            }
        }
    }

    public function toggleModulePermissions($moduleId, $checked)
    {
        $permissionIds = [];

        foreach ($this->groupedPermissions as $app) {
            if (isset($app['modules'][$moduleId])) {
                $permissionIds = collect($app['modules'][$moduleId]['permissions'])
                    ->pluck('id')
                    ->toArray();
                break;
            }
        }

        if ($checked) {
            $this->selectedPermissions = array_values(array_unique(
                array_merge($this->selectedPermissions, $permissionIds)
            ));
        } else {
            $this->selectedPermissions = array_values(array_diff($this->selectedPermissions, $permissionIds));
        }

        $this->dispatch('modulePermissionsToggled', moduleId: $moduleId, checked: $checked);
    }

    public function updatedSelectedPermissions()
    {
        $this->form->permissions = $this->selectedPermissions;
        $this->dispatch('permissions-updated');
    }

    public function isModuleFullySelected($moduleId)
    {
        foreach ($this->groupedPermissions as $app) {
            if (isset($app['modules'][$moduleId])) {
                $modulePermissionIds = collect($app['modules'][$moduleId]['permissions'])
                    ->pluck('id')
                    ->toArray();

            return empty(array_diff($modulePermissionIds, $this->selectedPermissions));
        }
    }
    return false;
}
}
