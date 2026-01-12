<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'prompt_id',
        'user_id',
        'estrellas',
        'resena',
    ];

    protected $casts = [
        'estrellas' => 'integer',
    ];

    public function prompt(): BelongsTo
    {
        return $this->belongsTo(Prompt::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot method to update prompt rating on save/delete
     */
    protected static function booted(): void
    {
        static::saved(function (Calificacion $calificacion) {
            $calificacion->prompt->recalcularPromedio();
        });

        static::deleted(function (Calificacion $calificacion) {
            $calificacion->prompt->recalcularPromedio();
        });
    }
}
