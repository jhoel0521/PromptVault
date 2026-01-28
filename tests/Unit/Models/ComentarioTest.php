<?php

namespace Tests\Unit\Models;

use App\Models\Comentario;
use App\Models\Prompt;
use App\Models\User;
use Tests\TestCase;

class ComentarioTest extends TestCase
{
    /**
     * Test que un comentario pertenece a un prompt
     */
    public function test_comentario_pertenece_a_prompt(): void
    {
        $comentario = Comentario::factory()->create();

        $this->assertNotNull($comentario->prompt);
        $this->assertInstanceOf(Prompt::class, $comentario->prompt);
    }

    /**
     * Test que un comentario pertenece a un usuario
     */
    public function test_comentario_pertenece_a_usuario(): void
    {
        $comentario = Comentario::factory()->create();

        $this->assertNotNull($comentario->user);
        $this->assertInstanceOf(User::class, $comentario->user);
    }

    /**
     * Test que un comentario puede tener un comentario padre (para replies)
     */
    public function test_comentario_puede_tener_padre(): void
    {
        $parent = Comentario::factory()->create();
        $child = Comentario::factory()->create(['parent_id' => $parent->id]);

        $this->assertEquals($parent->id, $child->parent_id);
        $this->assertNotNull($child->parent);
    }

    /**
     * Test que un comentario puede tener respuestas
     */
    public function test_comentario_puede_tener_respuestas(): void
    {
        $parent = Comentario::factory()->create();
        Comentario::factory(3)->create(['parent_id' => $parent->id]);

        $this->assertEquals(3, $parent->respuestas()->count());
    }
}
