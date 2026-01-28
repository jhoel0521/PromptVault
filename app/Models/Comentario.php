<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'prompt_id',
        'user_id',
        'contenido',
        'parent_id',
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
     * Comentario padre (si es una respuesta)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comentario::class, 'parent_id');
    }

    /**
     * Respuestas a este comentario
     */
    public function respuestas(): HasMany
    {
        return $this->hasMany(Comentario::class, 'parent_id');
    }

    /**
     * Verifica si es una respuesta
     */
    public function esRespuesta(): bool
    {
        return $this->parent_id !== null;
    }
}
