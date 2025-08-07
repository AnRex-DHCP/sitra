<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug'];
    public function modules()
    {
        return $this->hasMany(PermissionModule::class);
    }
}
