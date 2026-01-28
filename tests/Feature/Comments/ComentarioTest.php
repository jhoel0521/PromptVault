<?php

namespace Tests\Feature\Comments;

use App\Models\Comentario;
use App\Models\Prompt;
use App\Models\User;
use Tests\TestCase;

class ComentarioTest extends TestCase
{
    /**
     * Test que usuario puede comentar en prompt público
     */
    public function test_usuario_puede_comentar_en_prompt_publico(): void
    {
        $owner = User::factory()->create();
        $commenter = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'publico',
        ]);

        $response = $this->actingAs($commenter)->post(
            route('comentarios.store', ['prompt' => $prompt]),
            [
                'contenido' => 'Este es un comentario excelente',
            ]
        );

        $response->assertRedirect();

        $this->assertDatabaseHas('comentarios', [
            'prompt_id' => $prompt->id,
            'user_id' => $commenter->id,
            'contenido' => 'Este es un comentario excelente',
            'parent_id' => null,
        ]);
    }

    /**
     * Test que usuario puede responder a un comentario
     */
    public function test_usuario_puede_responder_a_comentario(): void
    {
        $owner = User::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'publico',
        ]);

        // Crear comentario original
        $originalComment = Comentario::create([
            'prompt_id' => $prompt->id,
            'user_id' => $user1->id,
            'contenido' => 'Comentario original',
        ]);

        // Responder al comentario
        $response = $this->actingAs($user2)->post(
            route('comentarios.store', ['prompt' => $prompt]),
            [
                'contenido' => 'Respuesta al comentario',
                'parent_id' => $originalComment->id,
            ]
        );

        $response->assertRedirect();

        // Validar que la respuesta está vinculada
        $reply = Comentario::where('parent_id', $originalComment->id)->first();
        $this->assertNotNull($reply);
        $this->assertEquals('Respuesta al comentario', $reply->contenido);
        $this->assertEquals($user2->id, $reply->user_id);
    }

    /**
     * Test que propietario del prompt puede eliminar comentario
     */
    public function test_propietario_puede_eliminar_comentario(): void
    {
        $owner = User::factory()->create();
        $commenter = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'publico',
        ]);

        $comment = Comentario::create([
            'prompt_id' => $prompt->id,
            'user_id' => $commenter->id,
            'contenido' => 'Comentario a eliminar',
        ]);

        $response = $this->actingAs($owner)->delete(
            route('comentarios.destroy', ['comentario' => $comment])
        );

        $response->assertRedirect();

        $this->assertDatabaseMissing('comentarios', [
            'id' => $comment->id,
        ]);
    }

    /**
     * Test que autor del comentario puede eliminarlo
     */
    public function test_usuario_puede_eliminar_propio_comentario(): void
    {
        $owner = User::factory()->create();
        $commenter = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'publico',
        ]);

        $comment = Comentario::create([
            'prompt_id' => $prompt->id,
            'user_id' => $commenter->id,
            'contenido' => 'Comentario a eliminar',
        ]);

        $response = $this->actingAs($commenter)->delete(
            route('comentarios.destroy', ['comentario' => $comment])
        );

        $response->assertRedirect();

        $this->assertDatabaseMissing('comentarios', [
            'id' => $comment->id,
        ]);
    }

    /**
     * Test que comentarios anidados se muestran correctamente
     */
    public function test_comentarios_anidados_se_muestran_correctamente(): void
    {
        $owner = User::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'publico',
        ]);

        // Comentario 1
        $comment1 = Comentario::create([
            'prompt_id' => $prompt->id,
            'user_id' => $user1->id,
            'contenido' => 'Primer comentario',
        ]);

        // Respuesta a comentario 1
        $reply1 = Comentario::create([
            'prompt_id' => $prompt->id,
            'user_id' => $user2->id,
            'contenido' => 'Respuesta al primer comentario',
            'parent_id' => $comment1->id,
        ]);

        // Respuesta a la respuesta (si soporta)
        $reply2 = Comentario::create([
            'prompt_id' => $prompt->id,
            'user_id' => $user1->id,
            'contenido' => 'Respuesta a la respuesta',
            'parent_id' => $reply1->id,
        ]);

        // Cargar comentarios del prompt
        $prompt->load('comentarios.respuestas');

        // Validar que la estructura es correcta
        $comments = Comentario::where('prompt_id', $prompt->id)
            ->whereNull('parent_id')
            ->with('respuestas.respuestas')
            ->get();

        $this->assertCount(1, $comments);
        $this->assertEquals('Primer comentario', $comments[0]->contenido);
        $this->assertCount(1, $comments[0]->respuestas);
        $this->assertEquals('Respuesta al primer comentario', $comments[0]->respuestas[0]->contenido);
    }
}
