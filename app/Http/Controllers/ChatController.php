<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ChatbotServiceInterface;
use App\Factories\ChatbotRepositoryFactory;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(
        private ChatbotServiceInterface $chatbotService
    ) {}

    /**
     * Vista principal del módulo de chat
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        // Obtener historial reciente para el sidebar
        $history = $this->chatbotService->getHistory($user, 20);

        // Agrupar por fecha
        $groupedHistory = $history->getCollection()->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

        // Obtener providers disponibles
        $providers = ChatbotRepositoryFactory::getAvailableProviders();
        $defaultProvider = ChatbotRepositoryFactory::getDefaultProvider()->value;

        return view('chat.index', compact('groupedHistory', 'providers', 'defaultProvider'));
    }

    /**
     * Obtener historial paginado (AJAX)
     */
    public function history(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $perPage = $request->input('per_page', 20);
        $history = $this->chatbotService->getHistory($user, $perPage);

        return response()->json([
            'data' => $history->items(),
            'meta' => [
                'current_page' => $history->currentPage(),
                'last_page' => $history->lastPage(),
                'total' => $history->total(),
            ],
        ]);
    }

    /**
     * Eliminar mensaje específico del historial
     */
    public function deleteMessage(Request $request, int $id)
    {
        /** @var User $user */
        $user = $request->user();

        $deleted = $this->chatbotService->deleteConversation($user, $id);

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Mensaje eliminado correctamente',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se pudo eliminar el mensaje',
        ], 404);
    }

    /**
     * Limpiar todo el historial del usuario
     */
    public function clearHistory(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $count = $this->chatbotService->clearHistory($user);

        return response()->json([
            'success' => true,
            'message' => "Se eliminaron {$count} mensajes del historial",
            'deleted_count' => $count,
        ]);
    }
}
