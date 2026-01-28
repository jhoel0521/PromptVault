<?php

namespace Tests\Feature\Ratings;

use App\Models\Calificacion;
use App\Models\Prompt;
use App\Models\User;
use Tests\TestCase;

class CalificacionTest extends TestCase
{
    /**
     * Test que usuario puede calificar un prompt
     */
    public function test_user_can_rate_prompt(): void
    {
        $owner = User::factory()->create();
        $rater = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'publico',
        ]);

        $response = $this->actingAs($rater)->post(
            route('prompts.calificar', ['prompt' => $prompt]),
            [
                'estrellas' => 4,
                'resena' => 'Excelente prompt, muy útil',
            ]
        );

        $response->assertRedirect();

        $this->assertDatabaseHas('calificaciones', [
            'prompt_id' => $prompt->id,
            'user_id' => $rater->id,
            'estrellas' => 4,
            'resena' => 'Excelente prompt, muy útil',
        ]);
    }

    /**
     * Test que usuario puede actualizar su calificación
     */
    public function test_user_can_update_rating(): void
    {
        $owner = User::factory()->create();
        $rater = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'publico',
        ]);

        // Primera calificación
        Calificacion::create([
            'prompt_id' => $prompt->id,
            'user_id' => $rater->id,
            'estrellas' => 3,
            'resena' => 'Primera reseña',
        ]);

        // Actualizar calificación
        $response = $this->actingAs($rater)->post(
            route('prompts.calificar', ['prompt' => $prompt]),
            [
                'estrellas' => 5,
                'resena' => 'Reseña actualizada - ahora es perfecto',
            ]
        );

        $response->assertRedirect();

        // Validar que solo existe 1 calificación (updateOrCreate)
        $this->assertEquals(1, Calificacion::where([
            'prompt_id' => $prompt->id,
            'user_id' => $rater->id,
        ])->count());

        // Validar que se actualizó
        $this->assertDatabaseHas('calificaciones', [
            'prompt_id' => $prompt->id,
            'user_id' => $rater->id,
            'estrellas' => 5,
            'resena' => 'Reseña actualizada - ahora es perfecto',
        ]);

        // Validar que la anterior ya no existe
        $this->assertDatabaseMissing('calificaciones', [
            'prompt_id' => $prompt->id,
            'user_id' => $rater->id,
            'estrellas' => 3,
        ]);
    }

    /**
     * Test que usuario no puede calificar dos veces (updateOrCreate)
     */
    public function test_user_cannot_rate_twice(): void
    {
        $owner = User::factory()->create();
        $rater = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'publico',
        ]);

        // Primera calificación
        $this->actingAs($rater)->post(
            route('prompts.calificar', ['prompt' => $prompt]),
            ['estrellas' => 4]
        );

        // Segunda calificación (debe actualizar, no crear nueva)
        $this->actingAs($rater)->post(
            route('prompts.calificar', ['prompt' => $prompt]),
            ['estrellas' => 5]
        );

        // Validar que solo hay 1 calificación de este usuario
        $count = Calificacion::where('prompt_id', $prompt->id)
            ->where('user_id', $rater->id)
            ->count();

        $this->assertEquals(1, $count);
    }

    /**
     * Test que promedio se actualiza automáticamente
     */
    public function test_prompt_average_updates_on_rating(): void
    {
        $owner = User::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'publico',
            'promedio_calificacion' => 0,
        ]);

        // Calificación 1: 5 estrellas
        $this->actingAs($user1)->post(
            route('prompts.calificar', ['prompt' => $prompt]),
            ['estrellas' => 5]
        );

        $prompt->refresh();
        $this->assertEquals(5.00, $prompt->promedio_calificacion);

        // Calificación 2: 3 estrellas (promedio = 4.0)
        $this->actingAs($user2)->post(
            route('prompts.calificar', ['prompt' => $prompt]),
            ['estrellas' => 3]
        );

        $prompt->refresh();
        $this->assertEquals(4.00, $prompt->promedio_calificacion);

        // Calificación 3: 4 estrellas (promedio = 4.0)
        $this->actingAs($user3)->post(
            route('prompts.calificar', ['prompt' => $prompt]),
            ['estrellas' => 4]
        );

        $prompt->refresh();
        $this->assertEquals(4.00, $prompt->promedio_calificacion);
    }

    /**
     * Test que valida rango de estrellas (1-5)
     */
    public function test_rating_range_validation(): void
    {
        $owner = User::factory()->create();
        $rater = User::factory()->create();

        $prompt = Prompt::factory()->create([
            'user_id' => $owner->id,
            'visibilidad' => 'publico',
        ]);

        // Intentar con 0 estrellas (debe fallar)
        $response = $this->actingAs($rater)->post(
            route('prompts.calificar', ['prompt' => $prompt]),
            ['estrellas' => 0]
        );

        $response->assertSessionHasErrors('estrellas');

        // Intentar con 6 estrellas (debe fallar)
        $response = $this->actingAs($rater)->post(
            route('prompts.calificar', ['prompt' => $prompt]),
            ['estrellas' => 6]
        );

        $response->assertSessionHasErrors('estrellas');

        // Intentar con estrellas válidas (debe pasar)
        $response = $this->actingAs($rater)->post(
            route('prompts.calificar', ['prompt' => $prompt]),
            ['estrellas' => 3]
        );

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }
}
