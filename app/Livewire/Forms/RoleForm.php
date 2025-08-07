<?php

namespace App\Livewire\Forms;

use App\Exceptions\PermissionValidationException;
use App\Http\Requests\ApplicationFormRequest;
use App\Http\Requests\RoleFormRequest;
use App\Models\Role;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RoleForm extends Form
{
    public $name = '';
    public $permissions = [];
    public $role;

    public ?int $id = null;
    public ?string $guard_name = 'web';
    public function rules(): array
    {
        return (new RoleFormRequest())->rules();
    }
    public function setRole($id)
    {
        $role = Role::findOrFail($id);
        $this->id = $role->id;
        $this->name = $role->name;
        $this->guard_name = $role->guard_name;
    }

    public function store()
    {
        $this->validate();

        $role = Role::create([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        $role->permissions()->sync($this->permissions);

        return $role;
    }

    public function update()
    {
        $this->validate();

        $this->role->update([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        $this->role->permissions()->sync($this->permissions);

        return $this->role;
    }
}
