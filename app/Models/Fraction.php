<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fraction extends Model
{
    /**
     * Los campos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'article_id',
        'code',
        'description',
    ];

    /**
     * Relación inversa con Article.
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
