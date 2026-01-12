<?php

namespace App\Repositories;

use App\Contracts\Repositories\EtiquetaRepositoryInterface;
use App\Models\Etiqueta;
use Illuminate\Support\Collection;

class EtiquetaRepository implements EtiquetaRepositoryInterface
{
    public function all(): Collection
    {
        return Etiqueta::orderBy('nombre')->get();
    }

    public function find(int $id): ?Etiqueta
    {
        return Etiqueta::find($id);
    }

    public function search(string $query, int $limit = 10): Collection
    {
        return Etiqueta::where('nombre', 'like', "%{$query}%")
            ->limit($limit)
            ->get();
    }

    public function create(array $data): Etiqueta
    {
        return Etiqueta::create($data);
    }
}
