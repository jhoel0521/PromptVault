<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'cuenta_activa',
        'ultimo_acceso',
        'foto_perfil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'cuenta_activa' => 'boolean',
            'ultimo_acceso' => 'datetime',
        ];
    }

    // Relaciones
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function prompts(): HasMany
    {
        return $this->hasMany(Prompt::class);
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
     * Prompts compartidos con este usuario
     */
    public function promptsCompartidos(): BelongsToMany
    {
        return $this->belongsToMany(Prompt::class, 'accesos_compartidos')
            ->withPivot('nivel_acceso')
            ->withTimestamps();
    }

    // Métodos helper para roles y permisos
    public function esAdmin(): bool
    {
        return $this->role?->nombre === 'admin';
    }

    public function esUsuario(): bool
    {
        return $this->role?->nombre === 'user';
    }

    public function esColaborador(): bool
    {
        return $this->role?->nombre === 'collaborator';
    }

    public function esGuest(): bool
    {
        return $this->role?->nombre === 'guest';
    }

    public function tienePermiso(string $nombrePermiso): bool
    {
        return $this->role?->tienePermiso($nombrePermiso) ?? false;
    }

    public function tieneAlgunoDeEstosPermisos(array $permisos): bool
    {
        foreach ($permisos as $permiso) {
            if ($this->tienePermiso($permiso)) {
                return true;
            }
        }

        return false;
    }

    public function tieneTodosEstosPermisos(array $permisos): bool
    {
        foreach ($permisos as $permiso) {
            if (! $this->tienePermiso($permiso)) {
                return false;
            }
        }

        return true;
    }

    public function puedeEditar(Prompt $prompt): bool
    {
        // El propietario siempre puede editar
        if ($this->id === $prompt->user_id) {
            return true;
        }

        // Admin puede editar todos
        if ($this->esAdmin()) {
            return true;
        }

        // Verificar si tiene acceso compartido como editor
        $acceso = $prompt->accesosCompartidos()
            ->where('user_id', $this->id)
            ->where('nivel_acceso', 'editor')
            ->first();

        return $acceso !== null;
    }

    public function puedeVer(Prompt $prompt): bool
    {
        return $prompt->esVisiblePara($this);
    }

    public function puedeComentar(Prompt $prompt): bool
    {
        // El propietario siempre puede comentar
        if ($this->id === $prompt->user_id) {
            return true;
        }

        // Admin puede comentar en todos
        if ($this->esAdmin()) {
            return true;
        }

        // Prompts públicos permiten comentarios
        if ($prompt->visibilidad === 'publico') {
            return true;
        }

        // Verificar si tiene acceso compartido como comentador o editor
        $acceso = $prompt->accesosCompartidos()
            ->where('user_id', $this->id)
            ->whereIn('nivel_acceso', ['comentador', 'editor'])
            ->first();

        return $acceso !== null;
    }

    public function actualizarUltimoAcceso(): void
    {
        $this->update(['ultimo_acceso' => now()]);
    }
}
