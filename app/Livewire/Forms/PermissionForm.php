<?php

namespace App\Livewire\Forms;

use App\Exceptions\PermissionValidationException;
use App\Models\Permission;
use App\Models\PermissionModule;
use Illuminate\Support\Str;
use Livewire\Form;
use App\Http\Requests\PermissionFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionForm extends Form
{
    public ?int $id = null;
    public ?string $name = '';
    public ?string $guard_name = 'web';
    public $application_id = '';
    public $permission_module_id = null;

    public function rules(): array
    {
        return (new PermissionFormRequest())->rules();
    }
    public function setPermission($id)
    {
        $permission = Permission::findOrFail($id);
        $permissionModule= PermissionModule::find($permission->permission_module_id);
        $this->id = $permission->id;
        $this->name = Str::replace($permissionModule->slug.'.', '', $permission->name);
        $this->guard_name = $permission->guard_name;
        $this->permission_module_id = $permission->permission_module_id;
        $this->application_id = $permissionModule->application_id;
    }

    public function store()
    {
        try {

            DB::beginTransaction();
            $this->validate();

            if (Permission::where('name', $this->name)->exists()) {
                throw new PermissionValidationException(
                    'El permiso ya existe',
                    ['general' => ['El permiso con este nombre ya existe en el sistema.']]
                );
            }

            $permission= new Permission();
            $permission->name= PermissionModule::find($this->permission_module_id)->slug.".".$this->name;
            $permission->guard_name= $this->guard_name;
            $permission->permission_module_id= $this->permission_module_id;
            $permission->save();

            DB::commit();
            $this->reset();

        } catch (PermissionValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear permiso: ' . $e->getMessage());
            throw new PermissionValidationException(
                'Error en el sistema',
                ['general' => ['Ha ocurrido un error al crear el permiso. Por favor, intente nuevamente.']]
            );
        }
    }

    public function update()
    {
        try {
            DB::beginTransaction();
            $this->validate();
            $permission = Permission::findOrFail($this->id);

            if (Permission::where('name', $this->name)
                ->where('id', '!=', $this->id)
                ->exists()) {
                throw new PermissionValidationException(
                    'Error al actualizar el permiso',
                    ['name' => ['El permiso ya existe en el sistema']]
                );
            }

            $permission->name= PermissionModule::find($this->permission_module_id)->slug.".".$this->name;
            $permission->guard_name= $this->guard_name;
            $permission->permission_module_id= $this->permission_module_id;
            $permission->save();

            DB::commit();
            $this->reset();
        } catch (PermissionValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar permiso: ' . $e->getMessage());
            throw new PermissionValidationException(
                'Error al actualizar el permiso',
                ['general' => ['Ha ocurrido un error al actualizar el permiso']]
            );
        }

    }
}
