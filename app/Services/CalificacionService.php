<?php

namespace App\Services;

use App\Contracts\Services\CalificacionServiceInterface;
use App\Models\Calificacion;
use App\Models\Prompt;
use App\Models\User;

class CalificacionService implements CalificacionServiceInterface
{
    /**
     * Calificar o actualizar calificación de un prompt
     *
     * @param  array  $data  ['estrellas' => int, 'resena' => string|null]
     * @return \App\Models\Calificacion
     */
    public function calificar(Prompt $prompt, User $user, array $data)
    {
        return Calificacion::updateOrCreate(
            [
                'prompt_id' => $prompt->id,
                'user_id' => $user->id,
            ],
            [
                'estrellas' => $data['estrellas'],
                'resena' => $data['resena'] ?? null,
            ]
        );
    }

    /**
     * Obtener calificación de un usuario para un prompt
     *
     * @return \App\Models\Calificacion|null
     */
    public function obtenerCalificacion(Prompt $prompt, User $user)
    {
        return Calificacion::where('prompt_id', $prompt->id)
            ->where('user_id', $user->id)
            ->first();
    }
}
