<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\EtiquetaRepositoryInterface;
use App\Contracts\Services\PromptServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        private PromptServiceInterface $promptService,
        private EtiquetaRepositoryInterface $etiquetaRepository
    ) {}

    /**
     * Página principal pública - Prompts públicos (sin autenticación requerida)
     */
    public function index(Request $request)
    {
        $filters = [
            'buscar' => $request->get('buscar'),
            'etiqueta' => $request->get('etiqueta'),
            'orden' => $request->get('orden', 'reciente'),
        ];

        // null = sin usuario, solo mostrará públicos
        $prompts = $this->promptService->listar(null, 15, $filters);
        $etiquetas = $this->etiquetaRepository->all();

        return view('home', compact('prompts', 'etiquetas'));
    }
}
