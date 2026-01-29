<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ChatbotServiceInterface;
use App\Contracts\Services\PromptServiceInterface;
use App\Enums\AiProvider;
use App\Factories\ChatbotRepositoryFactory;
use App\Models\Prompt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function __construct(
        private ChatbotServiceInterface $chatbotService,
        private PromptServiceInterface $promptService
    ) {}

    public function ask(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:500',
            'provider' => 'nullable|string|in:groq,claude,gemini',
        ]);

        try {
            /** @var User $user */
            $user = $request->user();

            $provider = isset($validated['provider'])
                ? AiProvider::from($validated['provider'])
                : null;

            $response = $this->chatbotService->ask(
                $user,
                $validated['message'],
                $provider
            );

            return response()->json($response);
        } catch (\Throwable $e) {
            Log::error('Chatbot Error: '.$e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'error' => 'Error interno: '.$e->getMessage(),
            ], 500);
        }
    }

    public function providers()
    {
        return response()->json([
            'providers' => ChatbotRepositoryFactory::getAvailableProviders(),
            'default' => ChatbotRepositoryFactory::getDefaultProvider()->value,
        ]);
    }

    public function createPrompt(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:150',
            'contenido' => 'required|string',
            'descripcion' => 'nullable|string|max:500',
        ]);

        try {
            /** @var User $user */
            $user = $request->user();

            $prompt = $this->promptService->crear($user, $validated);

            return response()->json([
                'success' => true,
                'prompt' => [
                    'id' => $prompt->id,
                    'titulo' => $prompt->titulo,
                    'descripcion' => $prompt->descripcion,
                ],
                'url' => route('prompts.show', $prompt),
                'message' => 'Prompt creado exitosamente',
            ]);
        } catch (\Throwable $e) {
            Log::error('Create Prompt Error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Error al crear el prompt: '.$e->getMessage(),
            ], 500);
        }
    }

    public function updatePrompt(Request $request, Prompt $prompt)
    {
        $this->authorize('update', $prompt);

        $validated = $request->validate([
            'titulo' => 'nullable|string|max:150',
            'contenido' => 'nullable|string',
            'descripcion' => 'nullable|string|max:500',
            'mensaje_cambio' => 'nullable|string|max:255',
        ]);

        try {
            $prompt = $this->promptService->actualizar($prompt, $validated);

            return response()->json([
                'success' => true,
                'prompt' => [
                    'id' => $prompt->id,
                    'titulo' => $prompt->titulo,
                    'descripcion' => $prompt->descripcion,
                    'version_actual' => $prompt->version_actual,
                ],
                'message' => 'Prompt actualizado exitosamente',
            ]);
        } catch (\Throwable $e) {
            Log::error('Update Prompt Error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar el prompt: '.$e->getMessage(),
            ], 500);
        }
    }
}
