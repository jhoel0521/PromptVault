<?php

namespace App\Models;

use App\Enums\TipoEvento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evento extends Model
{
    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'tipo',
        'ubicacion',
        'todo_el_dia',
        'color',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'todo_el_dia' => 'boolean',
        'tipo' => TipoEvento::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el color del tipo de evento
     */
    public function getTipoColorAttribute(): string
    {
        return $this->color ?? $this->tipo->color();
    }

    /**
     * Obtener la clase CSS del tipo
     */
    public function getTipoBadgeClassAttribute(): string
    {
        return $this->tipo->badgeClass();
    }
}
