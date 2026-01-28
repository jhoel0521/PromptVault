<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Prompt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    /**
     * Crear un comentario nuevo
     */
    public function store(Request $request, Prompt $prompt): RedirectResponse
    {
        // Verificar que el usuario puede ver el prompt para comentar
        if (! $prompt->esVisiblePara(auth()->user())) {
            abort(403);
        }

        // Verificar que el usuario puede comentar en este prompt
        if ($prompt->visibilidad === 'privado' && $prompt->user_id !== auth()->id()) {
            abort(403);
        }

        if ($prompt->visibilidad === 'enlace') {
            $nivelAcceso = $prompt->nivelAccesoPara(auth()->user());
            if (! in_array($nivelAcceso, ['comentador', 'editor', 'propietario'])) {
                abort(403);
            }
        }

        $validated = $request->validate([
            'contenido' => 'required|string|min:1|max:1000',
            'parent_id' => 'nullable|exists:comentarios,id',
        ]);

        Comentario::create([
            'prompt_id' => $prompt->id,
            'user_id' => auth()->id(),
            'contenido' => $validated['contenido'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return back()->with('success', 'Comentario agregado exitosamente');
    }

    /**
     * Eliminar un comentario
     */
    public function destroy(Comentario $comentario): RedirectResponse
    {
        // Solo el autor del comentario, el dueño del prompt, o admin pueden eliminar
        $canDelete = auth()->id() === $comentario->user_id ||
                     auth()->id() === $comentario->prompt->user_id ||
                     auth()->user()->esAdmin();

        if (! $canDelete) {
            abort(403);
        }

        $comentario->delete();

        return back()->with('success', 'Comentario eliminado exitosamente');
    }
}
