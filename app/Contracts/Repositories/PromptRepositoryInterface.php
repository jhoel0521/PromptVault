<?php

namespace App\Contracts\Repositories;

use App\Models\Prompt;
use Illuminate\Pagination\LengthAwarePaginator;

interface PromptRepositoryInterface
{
    /**
     * Obtener prompts con filtros flexibles
     *
     * @param  int|null  $userId  Si es null, solo públicos. Si tiene valor, filtra por usuario o compartidos
     * @param  int  $perPage  Cantidad por página
     * @param  array  $filters  Filtros: visibilidad, etiqueta, buscar, orden, compartidos_conmigo
     */
    public function getPrompts(?int $userId, int $perPage = 15, array $filters = []): LengthAwarePaginator;

    /**
     * Buscar un prompt por ID
     */
    public function find(int $id): ?Prompt;

    /**
     * Crear un nuevo prompt
     */
    public function create(array $data): Prompt;

    /**
     * Actualizar un prompt
     */
    public function update(Prompt $prompt, array $data): Prompt;

    /**
     * Eliminar un prompt
     */
    public function delete(Prompt $prompt): bool;

    /**
     * Sincronizar etiquetas
     */
    public function syncEtiquetas(Prompt $prompt, array $etiquetaIds): void;
}
