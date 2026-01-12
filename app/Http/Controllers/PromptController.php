<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\EtiquetaRepositoryInterface;
use App\Contracts\Services\CompartirServiceInterface;
use App\Contracts\Services\PromptServiceInterface;
use App\Models\Prompt;
use App\Models\User;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromptController extends Controller
{
    public function __construct(
        private PromptServiceInterface $promptService,
        private CompartirServiceInterface $compartirService,
        private EtiquetaRepositoryInterface $etiquetaRepository
    ) {}

    /**
     * Lista de prompts del usuario autenticado
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Prompt::class);

        $filters = [
            'buscar' => $request->get('buscar'),
            'etiqueta' => $request->get('etiqueta'),
            'visibilidad' => $request->get('visibilidad'),
            'orden' => $request->get('orden', 'reciente'),
            'solo_mios' => true,
        ];

        $prompts = $this->promptService->listar(Auth::user(), 15, $filters);
        $etiquetas = $this->etiquetaRepository->all();

        return view('prompts.index', compact('prompts', 'etiquetas'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $this->authorize('create', Prompt::class);

        $etiquetas = $this->etiquetaRepository->all();

        return view('prompts.create', compact('etiquetas'));
    }

    /**
     * Guardar nuevo prompt
     */
    public function store(Request $request)
    {
        $this->authorize('create', Prompt::class);

        $validated = $request->validate([
            'titulo' => 'required|string|max:150',
            'contenido' => 'required|string',
            'descripcion' => 'nullable|string',
            'visibilidad' => 'in:privado,publico,enlace',
            'etiquetas' => 'array',
            'etiquetas.*' => 'exists:etiquetas,id',
        ]);

        $prompt = $this->promptService->crear(Auth::user(), $validated);

        return redirect()->route('prompts.show', $prompt)
            ->with('success', 'Prompt creado exitosamente');
    }

    /**
     * Mostrar un prompt
     */
    public function show(Prompt $prompt)
    {
        $this->authorize('view', $prompt);

        $this->promptService->incrementarVistas($prompt);

        $prompt->load(['etiquetas', 'versiones', 'accesosCompartidos.user', 'comentarios.user', 'calificaciones.user']);

        return view('prompts.show', compact('prompt'));
    }

    /**
     * Formulario de edición
     */
    public function edit(Prompt $prompt)
    {
        $this->authorize('update', $prompt);

        $etiquetas = $this->etiquetaRepository->all();

        return view('prompts.edit', compact('prompt', 'etiquetas'));
    }

    /**
     * Actualizar prompt
     */
    public function update(Request $request, Prompt $prompt)
    {
        $this->authorize('update', $prompt);

        $validated = $request->validate([
            'titulo' => 'required|string|max:150',
            'contenido' => 'required|string',
            'descripcion' => 'nullable|string',
            'visibilidad' => 'in:privado,publico,enlace',
            'etiquetas' => 'array',
            'etiquetas.*' => 'exists:etiquetas,id',
            'mensaje_cambio' => 'nullable|string|max:255',
        ]);

        $this->promptService->actualizar($prompt, $validated);

        return redirect()->route('prompts.show', $prompt)
            ->with('success', 'Prompt actualizado exitosamente');
    }

    /**
     * Eliminar prompt
     */
    public function destroy(Prompt $prompt)
    {
        $this->authorize('delete', $prompt);

        $this->promptService->eliminar($prompt);

        return redirect()->route('prompts.index')
            ->with('success', 'Prompt eliminado exitosamente');
    }

    /**
     * Compartir prompt con un usuario
     */
    public function compartir(Request $request, Prompt $prompt)
    {
        $this->authorize('share', $prompt);

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'nivel_acceso' => 'required|in:lector,comentador,editor',
        ]);

        $usuario = User::where('email', $validated['email'])->first();

        if ($usuario->id === $prompt->user_id) {
            return back()->with('error', 'No puedes compartir contigo mismo');
        }

        $this->compartirService->compartir($prompt, $usuario, $validated['nivel_acceso']);

        return back()->with('success', "Prompt compartido con {$usuario->name}");
    }

    /**
     * Quitar acceso a un usuario
     */
    public function quitarAcceso(Prompt $prompt, User $user)
    {
        $this->authorize('share', $prompt);

        $this->compartirService->quitarAcceso($prompt, $user);

        return back()->with('success', 'Acceso removido');
    }

    /**
     * Ver historial de versiones
     */
    public function historial(Prompt $prompt)
    {
        $this->authorize('view', $prompt);

        $versiones = $prompt->versiones()
            ->orderBy('numero_version', 'desc')
            ->paginate(20);

        return view('prompts.historial', compact('prompt', 'versiones'));
    }

    /**
     * Restaurar una versión
     */
    public function restaurarVersion(Prompt $prompt, Version $version)
    {
        $this->authorize('update', $prompt);

        if ($version->prompt_id !== $prompt->id) {
            abort(403);
        }

        $this->promptService->actualizar($prompt, [
            'contenido' => $version->contenido,
            'mensaje_cambio' => "Restaurado desde versión {$version->numero_version}",
        ]);

        return redirect()->route('prompts.show', $prompt)
            ->with('success', 'Versión restaurada exitosamente');
    }

    /**
     * Prompts compartidos conmigo
     */
    public function compartidosConmigo(Request $request)
    {
        $filters = [
            'compartidos_conmigo' => true,
            'orden' => $request->get('orden', 'reciente'),
        ];

        $prompts = $this->promptService->listar(Auth::user(), 15, $filters);

        return view('prompts.compartidos', compact('prompts'));
    }
}
