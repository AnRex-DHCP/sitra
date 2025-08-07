<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;

class PermissionModule extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'application_id'];
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_module_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

}
