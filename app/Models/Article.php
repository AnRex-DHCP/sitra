<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    // Permite la asignación masiva de estos campos
    protected $fillable = [
        'number',
        'title',
    ];

    /**
     * Relación: un artículo tiene muchas fracciones
     */
    public function fractions(): HasMany
    {
        return $this->hasMany(Fraction::class);
    }
}