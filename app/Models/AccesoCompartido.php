<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccesoCompartido extends Model
{
    use HasFactory;

    protected $table = 'accesos_compartidos';

    protected $fillable = [
        'prompt_id',
        'user_id',
        'nivel_acceso',
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
     * Verifica si puede editar
     */
    public function puedeEditar(): bool
    {
        return $this->nivel_acceso === 'editor';
    }

    /**
     * Verifica si puede comentar
     */
    public function puedeComentar(): bool
    {
        return in_array($this->nivel_acceso, ['comentador', 'editor']);
    }
}
