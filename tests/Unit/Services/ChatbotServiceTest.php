<?php

namespace Tests\Unit\Services;

use App\Contracts\Repositories\PromptRepositoryInterface;
use App\Enums\AiProvider;
use App\Factories\ChatbotRepositoryFactory;
use App\Models\ChatbotConversacion;
use App\Models\Prompt;
use App\Models\User;
use App\Services\ChatbotService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class ChatbotServiceTest extends TestCase
{
    private ChatbotService $service;

    private $promptRepoMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->promptRepoMock = Mockery::mock(PromptRepositoryInterface::class);
        $this->service = new ChatbotService($this->promptRepoMock);
    }

    /**
     * Test que obtener prompts disponibles devuelve coleccion vacia sin keywords
     */
    public function test_obtener_prompts_disponibles_devuelve_coleccion_vacia_sin_keywords(): void
    {
        $user = User::factory()->create();

        $result = $this->service->getAvailablePrompts($user, null);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->isEmpty());
    }

    /**
     * Test que obtener prompts disponibles consulta repositorio con string
     */
    public function test_obtener_prompts_disponibles_consulta_repositorio_con_string(): void
    {
        $user = User::factory()->create();
        $prompts = collect([
            Prompt::factory()->make(['id' => 1, 'titulo' => 'Test 1']),
            Prompt::factory()->make(['id' => 2, 'titulo' => 'Test 2']),
        ]);

        $paginator = new LengthAwarePaginator($prompts->all(), 2, 10);

        $this->promptRepoMock
            ->shouldReceive('getPrompts')
            ->once()
            ->with($user->id, 10, Mockery::on(function ($filters) {
                return isset($filters['buscar']) && $filters['buscar'] === 'laravel';
            }))
            ->andReturn($paginator);

        $result = $this->service->getAvailablePrompts($user, 'laravel');

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    /**
     * Test que obtener prompts disponibles acepta array de keywords
     */
    public function test_obtener_prompts_disponibles_acepta_array_keywords(): void
    {
        $user = User::factory()->create();
        $prompts = collect([Prompt::factory()->make(['id' => 1])]);

        $paginator = new LengthAwarePaginator($prompts->all(), 1, 10);

        $this->promptRepoMock
            ->shouldReceive('getPrompts')
            ->once()
            ->with($user->id, 10, Mockery::on(function ($filters) {
                return isset($filters['any_keywords']) && is_array($filters['any_keywords']);
            }))
            ->andReturn($paginator);

        $result = $this->service->getAvailablePrompts($user, ['laravel', 'php']);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
    }

    /**
     * Test que preguntar crea conversacion y devuelve payload
     */
    public function test_preguntar_crea_conversacion_y_devuelve_payload(): void
    {
        $user = User::factory()->create();
        $prompt1 = Prompt::factory()->create(['user_id' => $user->id]);
        $prompt2 = Prompt::factory()->create(['user_id' => $user->id]);

        $prompts = collect([$prompt1, $prompt2]);
        $paginator = new LengthAwarePaginator($prompts->all(), 2, 10);

        $this->promptRepoMock
            ->shouldReceive('getPrompts')
            ->once()
            ->with($user->id, 10, Mockery::on(function ($filters) {
                return isset($filters['any_keywords']) && is_array($filters['any_keywords']);
            }))
            ->andReturn($paginator);

        $aiRepoMock = Mockery::mock();
        $aiRepoMock
            ->shouldReceive('ask')
            ->once()
            ->andReturn([
                'response' => 'Respuesta de prueba',
                'model' => 'test-model',
            ]);
        $aiRepoMock
            ->shouldReceive('getProviderName')
            ->andReturn('GROQ');

        $factoryMock = Mockery::mock('alias:'.ChatbotRepositoryFactory::class);
        $factoryMock
            ->shouldReceive('create')
            ->once()
            ->with(AiProvider::GROQ)
            ->andReturn($aiRepoMock);

        $result = $this->service->ask($user, 'Necesito ayuda con laravel testing', AiProvider::GROQ);

        $this->assertEquals('Respuesta de prueba', $result['response']);
        $this->assertEquals('test-model', $result['model']);
        $this->assertEquals('GROQ', $result['provider']);
        $this->assertCount(2, $result['related_prompts']);

        $this->assertDatabaseHas('chatbot_conversaciones', [
            'user_id' => $user->id,
            'provider' => 'groq',
            'model' => 'test-model',
        ]);
    }

    /**
     * Test que obtener historial devuelve conversaciones del usuario
     */
    public function test_obtener_historial_devuelve_conversaciones_usuario(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        for ($i = 0; $i < 12; $i++) {
            ChatbotConversacion::create([
                'user_id' => $user->id,
                'question' => 'Q'.$i,
                'response' => 'R'.$i,
                'provider' => 'groq',
                'model' => 'm',
                'related_prompts' => [],
            ]);
        }

        ChatbotConversacion::create([
            'user_id' => $otherUser->id,
            'question' => 'Q-other',
            'response' => 'R-other',
            'provider' => 'groq',
            'model' => 'm',
            'related_prompts' => [],
        ]);

        $result = $this->service->getHistory($user, 10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(12, $result->total());
        $this->assertEquals(10, $result->perPage());
    }

    /**
     * Test que eliminar conversacion elimina solo conversacion del usuario
     */
    public function test_eliminar_conversacion_elimina_solo_usuario(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $conversation = ChatbotConversacion::create([
            'user_id' => $user->id,
            'question' => 'Q1',
            'response' => 'R1',
            'provider' => 'groq',
            'model' => 'm',
            'related_prompts' => [],
        ]);

        $otherConversation = ChatbotConversacion::create([
            'user_id' => $otherUser->id,
            'question' => 'Q2',
            'response' => 'R2',
            'provider' => 'groq',
            'model' => 'm',
            'related_prompts' => [],
        ]);

        $result = $this->service->deleteConversation($user, $conversation->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('chatbot_conversaciones', ['id' => $conversation->id]);
        $this->assertDatabaseHas('chatbot_conversaciones', ['id' => $otherConversation->id]);
    }

    /**
     * Test que eliminar conversacion devuelve falso cuando no existe
     */
    public function test_eliminar_conversacion_devuelve_falso_cuando_no_existe(): void
    {
        $user = User::factory()->create();

        $result = $this->service->deleteConversation($user, 9999);

        $this->assertFalse($result);
    }

    /**
     * Test que limpiar historial elimina todas las conversaciones del usuario
     */
    public function test_limpiar_historial_elimina_todas_conversaciones(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        for ($i = 0; $i < 5; $i++) {
            ChatbotConversacion::create([
                'user_id' => $user->id,
                'question' => 'Q'.$i,
                'response' => 'R'.$i,
                'provider' => 'groq',
                'model' => 'm',
                'related_prompts' => [],
            ]);
        }

        ChatbotConversacion::create([
            'user_id' => $otherUser->id,
            'question' => 'Q-other',
            'response' => 'R-other',
            'provider' => 'groq',
            'model' => 'm',
            'related_prompts' => [],
        ]);

        $deleted = $this->service->clearHistory($user);

        $this->assertEquals(5, $deleted);
        $this->assertEquals(0, ChatbotConversacion::where('user_id', $user->id)->count());
        $this->assertEquals(1, ChatbotConversacion::where('user_id', $otherUser->id)->count());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
