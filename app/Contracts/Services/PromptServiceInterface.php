<?php

namespace App\Contracts\Services;

use App\Models\Prompt;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface PromptServiceInterface
{
    /**
     * Obtener prompts con filtros
     */
    public function listar(?User $user, int $perPage = 15, array $filters = []): LengthAwarePaginator;

    /**
     * Crear un nuevo prompt con su primera versión
     */
    public function crear(User $user, array $data): Prompt;

    /**
     * Actualizar prompt (crea nueva versión si el contenido cambió)
     */
    public function actualizar(Prompt $prompt, array $data): Prompt;

    /**
     * Eliminar prompt
     */
    public function eliminar(Prompt $prompt): bool;

    /**
     * Incrementar contador de vistas
     */
    public function incrementarVistas(Prompt $prompt): void;
}
