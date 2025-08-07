<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class PermissionFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules= [
            'application_id' => ['required'],
            'permission_module_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
        ];

        return $rules;
    }

    /*
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $permissionId = $this->permission ? $this->permission->id : null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                "unique:permissions,name,{$permissionId}"
            ],
            'application_id' => 'required|exists:applications,id',
            'permission_module_id' => 'required|exists:permission_modules,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del permiso es obligatorio',
            'name.unique' => 'Este permiso ya existe',
            'application_id.required' => 'La aplicación es obligatoria',
            'application_id.exists' => 'La aplicación seleccionada no es válida',
            'permission_module_id.required' => 'El módulo es obligatorio',
            'permission_module_id.exists' => 'El módulo seleccionado no es válido',
        ];
    }
    */
}
