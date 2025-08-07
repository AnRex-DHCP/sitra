<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{

    protected $fillable = [
        'name',
        'guard_name',
        'permission_module_id'
    ];

    protected $guarded = ['id'];

    public function module(): BelongsTo
    {
        return $this->belongsTo(PermissionModule::class, 'permission_module_id');
    }

    /**
     * Relación con roles
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.role'),
            config('permission.table_names.role_has_permissions'),
            config('permission.column_names.permission_pivot_key') ?: 'permission_id',
            config('permission.column_names.role_pivot_key') ?: 'role_id'
        );
    }

    /**
     * Relación polimórfica con modelos
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(
            getModelForGuard($this->attributes['guard_name']),
            'model',
            config('permission.table_names.model_has_permissions'),
            config('permission.column_names.permission_pivot_key') ?: 'permission_id',
            config('permission.column_names.model_morph_key')
        );
    }
}
