<?php

namespace App\Contracts\Services;

use App\Models\Prompt;
use App\Models\User;

interface CalificacionServiceInterface
{
    /**
     * Calificar o actualizar calificación de un prompt
     *
     * @param  array  $data  ['estrellas' => int, 'resena' => string|null]
     * @return \App\Models\Calificacion
     */
    public function calificar(Prompt $prompt, User $user, array $data);

    /**
     * Obtener calificación de un usuario para un prompt
     *
     * @return \App\Models\Calificacion|null
     */
    public function obtenerCalificacion(Prompt $prompt, User $user);
}
