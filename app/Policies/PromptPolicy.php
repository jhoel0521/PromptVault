<?php

namespace App\Policies;

use App\Contracts\Services\CompartirServiceInterface;
use App\Models\Prompt;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromptPolicy
{
    use HandlesAuthorization;

    public function __construct(
        private CompartirServiceInterface $compartirService
    ) {}

    /**
     * Determine whether the user can view any prompts.
     */
    public function viewAny(?User $user): bool
    {
        // Todos pueden ver la lista (filtrará por públicos si no está autenticado)
        return true;
    }

    /**
     * Determine whether the user can view the prompt.
     */
    public function view(?User $user, Prompt $prompt): bool
    {
        // Público, cualquiera puede ver
        if ($prompt->visibilidad === 'publico') {
            return true;
        }

        // Sin usuario, no puede ver privados
        if ($user === null) {
            return false;
        }

        // Verificar acceso
        $acceso = $this->compartirService->verificarAcceso($prompt, $user);

        return $acceso !== null;
    }

    /**
     * Determine whether the user can create prompts.
     */
    public function create(User $user): bool
    {
        // Cualquier usuario autenticado puede crear
        return true;
    }

    /**
     * Determine whether the user can update the prompt.
     */
    public function update(User $user, Prompt $prompt): bool
    {
        return $this->compartirService->puedeEditar($prompt, $user);
    }

    /**
     * Determine whether the user can delete the prompt.
     */
    public function delete(User $user, Prompt $prompt): bool
    {
        // Solo el propietario o admin puede eliminar
        if ($prompt->user_id === $user->id) {
            return true;
        }

        return $user->esAdmin();
    }

    /**
     * Determine whether the user can share the prompt.
     */
    public function share(User $user, Prompt $prompt): bool
    {
        // Solo el propietario puede compartir
        return $prompt->user_id === $user->id || $user->esAdmin();
    }

    /**
     * Determine whether the user can comment on the prompt.
     */
    public function comment(?User $user, Prompt $prompt): bool
    {
        if ($user === null) {
            return false;
        }

        return $this->compartirService->puedeComentar($prompt, $user);
    }

    /**
     * Determine whether the user can rate the prompt.
     */
    public function rate(User $user, Prompt $prompt): bool
    {
        // No puede calificar su propio prompt
        if ($prompt->user_id === $user->id) {
            return false;
        }

        // Solo puede calificar si puede ver
        return $this->view($user, $prompt);
    }
}
