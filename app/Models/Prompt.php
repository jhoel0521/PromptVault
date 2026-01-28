<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prompt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'contenido',
        'descripcion',
        'visibilidad',
        'version_actual',
        'promedio_calificacion',
        'conteo_vistas',
    ];

    protected $casts = [
        'promedio_calificacion' => 'decimal:2',
        'conteo_vistas' => 'integer',
        'version_actual' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function versiones(): HasMany
    {
        return $this->hasMany(Version::class);
    }

    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(Etiqueta::class, 'prompt_etiquetas');
    }

    public function accesosCompartidos(): HasMany
    {
        return $this->hasMany(AccesoCompartido::class);
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }

    public function calificaciones(): HasMany
    {
        return $this->hasMany(Calificacion::class);
    }

    /**
     * Usuarios con acceso compartido a este prompt
     */
    public function usuariosCompartidos(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'accesos_compartidos')
            ->withPivot('nivel_acceso')
            ->withTimestamps();
    }

    /**
     * Recalcula el promedio de calificaciones
     */
    public function recalcularPromedio(): void
    {
        $this->promedio_calificacion = $this->calificaciones()->avg('estrellas') ?? 0;
        $this->save();
    }

    /**
     * Incrementa el contador de vistas
     */
    public function incrementarVistas(): void
    {
        $this->increment('conteo_vistas');
    }

    /**
     * Verifica si el prompt es visible para un usuario
     */
    public function esVisiblePara(?User $user): bool
    {
        // Público es visible para todos
        if ($this->visibilidad === 'publico') {
            return true;
        }

        // Sin usuario autenticado, solo públicos
        if (! $user) {
            return false;
        }

        // El dueño siempre puede ver
        if ($this->user_id === $user->id) {
            return true;
        }

        // Admin puede ver todo
        if ($user->esAdmin()) {
            return true;
        }

        // Verificar si tiene acceso compartido
        return $this->accesosCompartidos()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Obtiene el nivel de acceso de un usuario
     */
    public function nivelAccesoPara(User $user): ?string
    {
        // El dueño tiene acceso total
        if ($this->user_id === $user->id) {
            return 'propietario';
        }

        // Admin tiene acceso total
        if ($user->esAdmin()) {
            return 'propietario';
        }

        $acceso = $this->accesosCompartidos()
            ->where('user_id', $user->id)
            ->first();

        return $acceso?->nivel_acceso;
    }
}
