<?php

namespace App\Console\Commands;

use App\Contracts\Services\ChatbotServiceInterface;
use App\Enums\AiProvider;
use Illuminate\Console\Command;

class CheckModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:models
                            {--google-ai-studio : Consultar modelos de Google AI Studio}
                            {--GOOGLE_AI_STUDIO : Alias de compatibilidad}
                            {--groq : Consultar modelos de Groq}
                            {--claude : Consultar modelos de Claude}
                            {--all : Consultar todos los providers disponibles}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listar modelos disponibles por provider';

    /**
     * Execute the console command.
     */
    public function handle(ChatbotServiceInterface $chatbotService)
    {
        $useGoogle = (bool) $this->option('google-ai-studio') || (bool) $this->option('GOOGLE_AI_STUDIO');
        $useGroq = (bool) $this->option('groq');
        $useClaude = (bool) $this->option('claude');
        $useAll = (bool) $this->option('all');

        if (! $useGoogle && ! $useGroq && ! $useClaude && ! $useAll) {
            $this->error('Debes indicar un provider. Ejemplo: php artisan check:models --google-ai-studio');

            return self::FAILURE;
        }

        $providers = [];
        if ($useAll || $useGoogle) {
            $providers[] = AiProvider::GEMINI;
        }
        if ($useAll || $useGroq) {
            $providers[] = AiProvider::GROQ;
        }
        if ($useAll || $useClaude) {
            $providers[] = AiProvider::CLAUDE;
        }

        foreach ($providers as $provider) {
            $this->newLine();
            $this->info('Provider: '.$provider->getDisplayName());

            $result = $chatbotService->getAvailableModels($provider);

            if (! $result['success']) {
                $this->error($result['message'] ?? 'Error desconocido');

                continue;
            }

            if (empty($result['rows'])) {
                $this->warn('No se encontraron modelos.');

                continue;
            }

            $rows = collect($result['rows'])
                ->map(fn ($row) => [$row['model'], $row['name'], $row['methods']])
                ->values()
                ->all();

            $this->table(['Modelo', 'Nombre', 'Métodos'], $rows);
        }

        return self::SUCCESS;
    }
}
