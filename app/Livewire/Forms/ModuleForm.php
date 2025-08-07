<?php

namespace App\Livewire\Forms;

use App\Exceptions\PermissionValidationException;
use App\Http\Requests\ApplicationFormRequest;
use App\Http\Requests\ModuleFormRequest;
use App\Models\Application;
use App\Models\PermissionModule;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ModuleForm extends Form
{
    public ?int $id = null;
    public $application_id = '';
    public ?string $name = '';
    public ?string $slug = '';
    public function rules(): array
    {
        return (new ModuleFormRequest())->rules();
    }
    public function setModule($id)
    {
        $module = PermissionModule::findOrFail($id);
        $this->id = $module->id;
        $this->application_id = $module->application_id;
        $this->name = $module->name;
        $this->slug = $module->slug;
    }

    public function store()
    {
        try {

            DB::beginTransaction();
            $this->validate();

            if (PermissionModule::
                where('name', $this->name)
                ->where('application_id', $this->application_id
                )->exists()) {
                throw new PermissionValidationException(
                    'El módulo ya existe',
                    ['general' => ['Un módulo con este nombre ya existe en el sistema.']]
                );
            }

            $module= new PermissionModule();
            $module->application_id= $this->application_id;
            $module->name= $this->name;
            $module->slug= Application::find($this->application_id)->slug."-".Str::slug($this->name, "-");
            $module->save();

            DB::commit();
            $this->reset();

        } catch (PermissionValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear: ' . $e->getMessage());
            throw new PermissionValidationException(
                'Error en el sistema',
                ['general' => ['Ha ocurrido un error al crear. Por favor, intente nuevamente.']]
            );
        }
    }

    public function update()
    {
        try {
            DB::beginTransaction();
            $this->validate();
            $module = PermissionModule::findOrFail($this->id);

            if (PermissionModule::where('name', $this->name)
                ->where('id', '!=', $this->id)
                ->where('application_id', $this->application_id)
                ->exists()) {
                throw new PermissionValidationException(
                    'Error al actualizar el módulo',
                    ['name' => ['El módulo ya existe en el sistema']]
                );
            }

            $application= Application::find($this->application_id);
            $module->application_id= $this->application_id;
            $module->name= $this->name;
            $module->slug= Application::find($this->application_id)->slug."-".Str::slug($this->name, "-");
            $module->save();

            DB::commit();
            $this->reset();
        } catch (PermissionValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar: ' . $e->getMessage());
            throw new PermissionValidationException(
                'Error al actualizar',
                ['general' => ['Ha ocurrido un error al actualizar']]
            );
        }

    }
}
