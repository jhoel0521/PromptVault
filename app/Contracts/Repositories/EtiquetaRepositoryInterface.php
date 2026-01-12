<?php

namespace App\Contracts\Repositories;

use App\Models\Etiqueta;
use Illuminate\Support\Collection;

interface EtiquetaRepositoryInterface
{
    /**
     * Obtener todas las etiquetas
     */
    public function all(): Collection;

    /**
     * Buscar etiqueta por ID
     */
    public function find(int $id): ?Etiqueta;

    /**
     * Buscar etiquetas por nombre
     */
    public function search(string $query, int $limit = 10): Collection;

    /**
     * Crear una etiqueta
     */
    public function create(array $data): Etiqueta;
}
