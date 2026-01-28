<?php

namespace App\Policies;

use App\Models\Comentario;
use App\Models\Prompt;
use App\Models\User;

class ComentarioPolicy
{
    /**
     * Determina si el usuario puede comentar en un prompt
     */
    public function comment(User $user, Prompt $prompt): bool
    {
        // El usuario debe poder ver el prompt para comentar
        if (! $prompt->esVisiblePara($user)) {
            return false;
        }

        // Si el prompt es público, cualquiera puede comentar
        if ($prompt->visibilidad === 'publico') {
            return true;
        }

        // Si es privado, solo el propietario puede comentar
        if ($prompt->visibilidad === 'privado') {
            return $prompt->user_id === $user->id;
        }

        // Si es de enlace, solo usuarios con AccesoCompartido pueden comentar
        if ($prompt->visibilidad === 'enlace') {
            $nivelAcceso = $prompt->nivelAccesoPara($user);

            return in_array($nivelAcceso, ['comentador', 'editor', 'propietario']);
        }

        return false;
    }

    /**
     * Determina si el usuario puede eliminar un comentario
     */
    public function delete(User $user, Comentario $comentario): bool
    {
        // El propietario del comentario puede eliminarlo
        if ($comentario->user_id === $user->id) {
            return true;
        }

        // El propietario del prompt puede eliminar cualquier comentario
        if ($comentario->prompt->user_id === $user->id) {
            return true;
        }

        // Admin puede eliminar cualquier comentario
        if ($user->esAdmin()) {
            return true;
        }

        return false;
    }
}
