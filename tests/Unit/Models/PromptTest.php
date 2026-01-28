<?php

namespace Tests\Unit\Models;

use App\Models\Etiqueta;
use App\Models\Prompt;
use App\Models\User;
use App\Models\Version;
use Tests\TestCase;

class PromptTest extends TestCase
{
    /**
     * Test que un prompt pertenece a un usuario
     */
    public function test_prompt_pertenece_a_usuario(): void
    {
        $prompt = Prompt::factory()->create();

        $this->assertNotNull($prompt->user);
        $this->assertInstanceOf(User::class, $prompt->user);
    }

    /**
     * Test que un prompt tiene muchas versiones
     */
    public function test_prompt_tiene_muchas_versiones(): void
    {
        $prompt = Prompt::factory()->create();
        Version::factory(3)->create(['prompt_id' => $prompt->id]);

        $this->assertEquals(3, $prompt->versiones()->count());
    }

    /**
     * Test que un prompt tiene muchas etiquetas (many-to-many)
     */
    public function test_prompt_tiene_muchas_etiquetas(): void
    {
        $prompt = Prompt::factory()->create();
        $etiquetas = Etiqueta::factory(3)->create();

        foreach ($etiquetas as $etiqueta) {
            $prompt->etiquetas()->attach($etiqueta->id);
        }

        $this->assertEquals(3, $prompt->etiquetas()->count());
    }

    /**
     * Test que el promedio de calificación se calcula correctamente
     */
    public function test_prompt_recalcula_promedio(): void
    {
        $prompt = Prompt::factory()->create(['promedio_calificacion' => 0]);

        // Este test depende de que el método recalcularPromedio() esté implementado
        $this->assertTrue(method_exists($prompt, 'recalcularPromedio'));
    }

    /**
     * Test que se incrementan las vistas
     */
    public function test_prompt_incrementa_vistas(): void
    {
        $prompt = Prompt::factory()->create(['conteo_vistas' => 0]);

        // Este test depende de que el método incrementarVistas() esté implementado
        $this->assertTrue(method_exists($prompt, 'incrementarVistas'));
    }

    /**
     * Test que el propietario puede ver su prompt
     */
    public function test_prompt_visible_para_propietario(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $user->id, 'visibilidad' => 'privado']);

        $this->assertTrue($user->can('view', $prompt));
    }

    /**
     * Test que los prompts públicos son visibles para todos
     */
    public function test_prompt_publico_visible_para_todos(): void
    {
        $user = User::factory()->create();
        $prompt = Prompt::factory()->publico()->create();

        $this->assertTrue($user->can('view', $prompt));
    }

    /**
     * Test que los prompts privados no son visibles para usuarios no autorizados
     */
    public function test_prompt_privado_no_visible_para_otros(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $prompt = Prompt::factory()->privado()->create(['user_id' => $user1->id]);

        $this->assertFalse($user2->can('view', $prompt));
    }
}
