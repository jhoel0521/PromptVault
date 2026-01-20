<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ChatbotServiceInterface;
use App\Factories\ChatbotRepositoryFactory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function __construct(
        private ChatbotServiceInterface $chatbotService
    ) {}

    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        try {
            /** @var User $user */
            $user = $request->user();

            $response = $this->chatbotService->ask(
                $user,
                $request->input('message')
            );

            return response()->json($response);
        } catch (\Throwable $e) { // Capturar todo, incuyendo errores fatales
            Log::error('Chatbot Error: '.$e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'error' => 'Error interno: '.$e->getMessage(), // Mostrar error real para debug
            ], 500);
        }
    }

    public function providers()
    {
        return response()->json([
            'providers' => ChatbotRepositoryFactory::getAvailableProviders(),
        ]);
    }
}
