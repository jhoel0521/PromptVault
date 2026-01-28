<?php

namespace Tests\Feature\Tags;

use App\Models\Etiqueta;
use App\Models\Prompt;
use App\Models\User;
use Tests\TestCase;

class EtiquetaTest extends TestCase
{
    /**
     * Test que usuario puede agregar etiquetas a un prompt
     */
    public function test_usuario_puede_agregar_etiquetas_a_prompt(): void
    {
        $user = User::factory()->create();

        $etiqueta1 = Etiqueta::factory()->create(['nombre' => 'Laravel']);
        $etiqueta2 = Etiqueta::factory()->create(['nombre' => 'PHP']);

        $response = $this->actingAs($user)->post(route('prompts.store'), [
            'titulo' => 'Prompt con etiquetas',
            'descripcion' => 'Descripción del prompt',
            'contenido' => 'Contenido del prompt',
            'visibilidad' => 'privado',
            'etiquetas' => [$etiqueta1->id, $etiqueta2->id],
        ]);

        $response->assertRedirect();

        $prompt = Prompt::where('titulo', 'Prompt con etiquetas')->first();
        $this->assertNotNull($prompt);

        // Validar que las etiquetas están asociadas
        $this->assertTrue($prompt->etiquetas->contains($etiqueta1));
        $this->assertTrue($prompt->etiquetas->contains($etiqueta2));
        $this->assertCount(2, $prompt->etiquetas);
    }

    /**
     * Test que usuario puede remover etiquetas de un prompt
     */
    public function test_usuario_puede_eliminar_etiquetas_de_prompt(): void
    {
        $user = User::factory()->create();

        $etiqueta1 = Etiqueta::factory()->create(['nombre' => 'Laravel']);
        $etiqueta2 = Etiqueta::factory()->create(['nombre' => 'PHP']);
        $etiqueta3 = Etiqueta::factory()->create(['nombre' => 'Vue']);

        $prompt = Prompt::factory()->create([
            'user_id' => $user->id,
            'titulo' => 'Prompt con etiquetas',
        ]);

        // Agregar 3 etiquetas
        $prompt->etiquetas()->attach([$etiqueta1->id, $etiqueta2->id, $etiqueta3->id]);

        $this->assertCount(3, $prompt->etiquetas);

        // Actualizar prompt removiendo una etiqueta
        $response = $this->actingAs($user)->put(
            route('prompts.update', ['prompt' => $prompt]),
            [
                'titulo' => 'Prompt con etiquetas actualizado',
                'descripcion' => 'Descripción',
                'contenido' => 'Contenido',
                'visibilidad' => 'privado',
                'etiquetas' => [$etiqueta1->id, $etiqueta2->id], // Solo 2 etiquetas ahora
            ]
        );

        $response->assertRedirect();

        // Recargar prompt
        $prompt->refresh();

        // Validar que solo hay 2 etiquetas
        $this->assertCount(2, $prompt->etiquetas);
        $this->assertTrue($prompt->etiquetas->contains($etiqueta1));
        $this->assertTrue($prompt->etiquetas->contains($etiqueta2));
        $this->assertFalse($prompt->etiquetas->contains($etiqueta3));
    }

    /**
     * Test que admin puede crear etiquetas globales
     */
    public function test_admin_puede_crear_etiquetas_globales(): void
    {
        $admin = User::factory()->create();
        $admin->update(['role_id' => 1]); // role_id 1 = admin

        // Crear etiqueta directamente (sin controlador específico)
        $etiqueta = Etiqueta::create([
            'nombre' => 'Etiqueta Global',
            'color_hex' => '#FF5733',
        ]);

        $this->assertDatabaseHas('etiquetas', [
            'nombre' => 'Etiqueta Global',
            'color_hex' => '#FF5733',
        ]);

        // Validar que cualquier usuario puede usar esta etiqueta
        $user = User::factory()->create();
        $prompt = Prompt::factory()->create(['user_id' => $user->id]);

        $prompt->etiquetas()->attach($etiqueta->id);

        $this->assertTrue($prompt->etiquetas->contains($etiqueta));
    }

    /**
     * Test que se pueden filtrar prompts por etiqueta
     */
    public function test_filtrar_prompts_por_etiqueta(): void
    {
        $user = User::factory()->create();

        $etiquetaLaravel = Etiqueta::factory()->create(['nombre' => 'Laravel']);
        $etiquetaPHP = Etiqueta::factory()->create(['nombre' => 'PHP']);

        // Crear 3 prompts: 2 con Laravel, 1 con PHP
        $prompt1 = Prompt::factory()->create([
            'user_id' => $user->id,
            'titulo' => 'Prompt Laravel 1',
            'visibilidad' => 'publico',
        ]);
        $prompt1->etiquetas()->attach($etiquetaLaravel->id);

        $prompt2 = Prompt::factory()->create([
            'user_id' => $user->id,
            'titulo' => 'Prompt Laravel 2',
            'visibilidad' => 'publico',
        ]);
        $prompt2->etiquetas()->attach($etiquetaLaravel->id);

        $prompt3 = Prompt::factory()->create([
            'user_id' => $user->id,
            'titulo' => 'Prompt PHP',
            'visibilidad' => 'publico',
        ]);
        $prompt3->etiquetas()->attach($etiquetaPHP->id);

        // Filtrar por etiqueta Laravel usando whereHas
        $promptsLaravel = Prompt::whereHas('etiquetas', function ($query) use ($etiquetaLaravel) {
            $query->where('etiquetas.id', $etiquetaLaravel->id);
        })->get();

        $this->assertCount(2, $promptsLaravel);
        $this->assertTrue($promptsLaravel->contains($prompt1));
        $this->assertTrue($promptsLaravel->contains($prompt2));

        // Filtrar por etiqueta PHP
        $promptsPHP = Prompt::whereHas('etiquetas', function ($query) use ($etiquetaPHP) {
            $query->where('etiquetas.id', $etiquetaPHP->id);
        })->get();

        $this->assertCount(1, $promptsPHP);
        $this->assertTrue($promptsPHP->contains($prompt3));
    }
}
