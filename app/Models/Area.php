<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Area::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Area::class, 'parent_id');
    }

    // Nombre completo con jerarquía (incluye el propio nombre)
    public function getFullNameAttribute()
    {
        if ($this->parent) {
            return $this->parent->full_name . ' > ' . $this->name;
        }
        return $this->name;
    }

    // Jerarquía SOLO de padres (sin incluir el propio nombre)
    public function getParentFullNameAttribute()
    {
        if ($this->parent) {
            return $this->parent->full_name;
        }
        return null;
    }

    // Obtener todos los descendientes (incluido el área seleccionada)
    public function getAllDescendantsAndSelfIds()
{
    $ids = [$this->id];
    foreach ($this->children as $child) {
                $child->loadMissing('children');
        $ids = array_merge($ids, $child->getAllDescendantsAndSelfIds());
    }
    return $ids;
}
}
