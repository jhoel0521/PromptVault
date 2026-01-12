<?php

namespace App\Repositories;

use App\Contracts\Repositories\PromptRepositoryInterface;
use App\Models\Prompt;
use Illuminate\Pagination\LengthAwarePaginator;

class PromptRepository implements PromptRepositoryInterface
{
    public function getPrompts(?int $userId, int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Prompt::with(['etiquetas', 'user']);

        // Si no hay usuario, solo públicos
        if ($userId === null) {
            $query->where('visibilidad', 'publico');
        } else {
            // Filtrar por tipo de vista
            if (isset($filters['compartidos_conmigo']) && $filters['compartidos_conmigo']) {
                // Ver solo los compartidos conmigo
                $query->whereHas('accesosCompartidos', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
            } elseif (isset($filters['solo_mios']) && $filters['solo_mios']) {
                // Ver solo mis prompts
                $query->where('user_id', $userId);
            } else {
                // Ver mis prompts + los compartidos conmigo + públicos
                $query->where(function ($q) use ($userId) {
                    $q->where('user_id', $userId)
                        ->orWhere('visibilidad', 'publico')
                        ->orWhereHas('accesosCompartidos', function ($sq) use ($userId) {
                            $sq->where('user_id', $userId);
                        });
                });
            }
        }

        // Filtro por visibilidad específica
        if (isset($filters['visibilidad'])) {
            $query->where('visibilidad', $filters['visibilidad']);
        }

        // Filtro por etiqueta
        if (isset($filters['etiqueta'])) {
            $query->whereHas('etiquetas', function ($q) use ($filters) {
                $q->where('nombre', $filters['etiqueta']);
            });
        }

        // Búsqueda por texto (frase exacta o parcial)
        if (isset($filters['buscar']) && ! empty($filters['buscar'])) {
            $buscar = $filters['buscar'];
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                    ->orWhere('contenido', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        // Búsqueda por múltiples palabras clave (OR)
        if (isset($filters['any_keywords']) && is_array($filters['any_keywords']) && ! empty($filters['any_keywords'])) {
            $keywords = $filters['any_keywords'];
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('titulo', 'like', "%{$keyword}%")
                        ->orWhere('contenido', 'like', "%{$keyword}%")
                        ->orWhere('descripcion', 'like', "%{$keyword}%");
                }
            });
        }

        // Ordenamiento
        $orden = $filters['orden'] ?? 'reciente';
        switch ($orden) {
            case 'titulo':
                $query->orderBy('titulo');
                break;
            case 'vistas':
                $query->orderBy('conteo_vistas', 'desc');
                break;
            case 'calificacion':
                $query->orderBy('promedio_calificacion', 'desc');
                break;
            default:
                $query->latest();
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): ?Prompt
    {
        return Prompt::with(['etiquetas', 'user', 'versiones', 'accesosCompartidos.user', 'comentarios.user', 'calificaciones.user'])
            ->find($id);
    }

    public function create(array $data): Prompt
    {
        return Prompt::create($data);
    }

    public function update(Prompt $prompt, array $data): Prompt
    {
        $prompt->update($data);

        return $prompt->fresh();
    }

    public function delete(Prompt $prompt): bool
    {
        return $prompt->delete();
    }

    public function syncEtiquetas(Prompt $prompt, array $etiquetaIds): void
    {
        $prompt->etiquetas()->sync($etiquetaIds);
    }
}
