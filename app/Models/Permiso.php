<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permiso extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'modulo',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permiso');
    }

    /**
     * Obtener permisos agrupados por módulo
     */
    public static function agrupadosPorModulo()
    {
        return self::all()->groupBy('modulo');
    }
}
