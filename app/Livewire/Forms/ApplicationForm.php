<?php

namespace App\Livewire\Forms;

use App\Exceptions\PermissionValidationException;
use App\Http\Requests\ApplicationFormRequest;
use App\Models\Application;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApplicationForm extends Form
{
    public ?int $id = null;
    public ?string $name = '';
    public ?string $slug = '';
    public function rules(): array
    {
        return (new ApplicationFormRequest())->rules();
    }
    public function setApplication($id)
    {
        $application = Application::findOrFail($id);
        $this->id = $application->id;
        $this->name = $application->name;
        $this->slug = $application->slug;
    }

    public function store()
    {
        try {

            DB::beginTransaction();
            $this->validate();

            if (Application::where('name', $this->name)->exists()) {
                throw new PermissionValidationException(
                    'La aplicación ya existe',
                    ['general' => ['Una aplicación con este nombre ya existe en el sistema.']]
                );
            }

            $application= new Application();
            $application->name= $this->name;
            $application->slug= Str::slug($this->name, "-");
            $application->save();

            DB::commit();
            $this->reset();

        } catch (PermissionValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear la aplicación: ' . $e->getMessage());
            throw new PermissionValidationException(
                'Error en el sistema',
                ['general' => ['Ha ocurrido un error al crear la aplicación. Por favor, intente nuevamente.']]
            );
        }
    }

    public function update()
    {
        try {
            DB::beginTransaction();
            $this->validate();
            $application = Application::findOrFail($this->id);

            if (Application::where('name', $this->name)
                ->where('id', '!=', $this->id)
                ->exists()) {
                throw new PermissionValidationException(
                    'Error al actualizar la aplicación',
                    ['name' => ['La aplicación ya existe en el sistema']]
                );
            }

            $application->name= $this->name;
            $application->slug= Str::slug($this->name, "-");
            $application->save();

            DB::commit();
            $this->reset();
        } catch (PermissionValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar la aplicación: ' . $e->getMessage());
            throw new PermissionValidationException(
                'Error al actualizar la aplicación',
                ['general' => ['Ha ocurrido un error al actualizar la aplicación']]
            );
        }

    }
}
