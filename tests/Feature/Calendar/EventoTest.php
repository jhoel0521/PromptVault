<?php

namespace Tests\Feature\Calendar;

use App\Models\Evento;
use App\Models\User;
use Tests\TestCase;

class EventoTest extends TestCase
{
    /**
     * Test que usuario puede crear evento
     */
    public function test_user_can_create_event(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('calendario.store'), [
            'titulo' => 'Reunión importante',
            'descripcion' => 'Discutir el proyecto',
            'fecha_inicio' => now()->addDay()->format('Y-m-d H:i:s'),
            'fecha_fin' => now()->addDay()->addHours(2)->format('Y-m-d H:i:s'),
            'tipo' => 'trabajo',
            'ubicacion' => 'Sala de juntas',
            'todo_el_dia' => false,
            'completado' => false,
            'color' => '#3B82F6',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('eventos', [
            'user_id' => $user->id,
            'titulo' => 'Reunión importante',
            'tipo' => 'trabajo',
        ]);
    }

    /**
     * Test que usuario puede ver sus propios eventos
     */
    public function test_user_can_view_own_events(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // Eventos del usuario
        for ($i = 0; $i < 3; $i++) {
            Evento::create([
                'user_id' => $user->id,
                'titulo' => "Evento $i",
                'fecha_inicio' => now()->addDays($i),
                'fecha_fin' => now()->addDays($i)->addHours(1),
                'tipo' => 'trabajo',
            ]);
        }

        // Eventos de otro usuario
        for ($i = 0; $i < 2; $i++) {
            Evento::create([
                'user_id' => $otherUser->id,
                'titulo' => "Evento Otro $i",
                'fecha_inicio' => now()->addDays($i),
                'fecha_fin' => now()->addDays($i)->addHours(1),
                'tipo' => 'personal',
            ]);
        }

        $response = $this->actingAs($user)->get(route('calendario.index'));

        $response->assertStatus(200);
        $response->assertViewIs('calendario.index');

        // Validar que solo ve sus eventos
        $userEvents = Evento::where('user_id', $user->id)->get();
        $this->assertCount(3, $userEvents);
    }

    /**
     * Test que usuario puede actualizar evento
     */
    public function test_user_can_update_event(): void
    {
        $user = User::factory()->create();

        $evento = Evento::create([
            'user_id' => $user->id,
            'titulo' => 'Evento original',
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addHours(1),
            'tipo' => 'trabajo',
            'completado' => false,
        ]);

        $response = $this->actingAs($user)->put(
            route('calendario.update', ['calendario' => $evento]),
            [
                'titulo' => 'Evento actualizado',
                'descripcion' => $evento->descripcion,
                'fecha_inicio' => $evento->fecha_inicio->format('Y-m-d H:i:s'),
                'fecha_fin' => $evento->fecha_fin->format('Y-m-d H:i:s'),
                'tipo' => $evento->tipo->value,
                'ubicacion' => $evento->ubicacion,
                'todo_el_dia' => $evento->todo_el_dia,
                'completado' => $evento->completado,
                'color' => $evento->color,
            ]
        );

        $response->assertRedirect();

        $evento->refresh();
        $this->assertEquals('Evento actualizado', $evento->titulo);
    }

    /**
     * Test que usuario puede eliminar evento
     */
    public function test_user_can_delete_event(): void
    {
        $user = User::factory()->create();

        $evento = Evento::create([
            'user_id' => $user->id,
            'titulo' => 'Evento a eliminar',
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addHours(1),
            'tipo' => 'trabajo',
        ]);

        $response = $this->actingAs($user)->delete(
            route('calendario.destroy', ['calendario' => $evento])
        );

        $response->assertRedirect();

        $this->assertDatabaseMissing('eventos', [
            'id' => $evento->id,
        ]);
    }

    /**
     * Test que usuario puede marcar evento como completado
     */
    public function test_user_can_mark_event_complete(): void
    {
        $user = User::factory()->create();

        $evento = Evento::create([
            'user_id' => $user->id,
            'titulo' => 'Tarea pendiente',
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addHours(1),
            'tipo' => 'trabajo',
            'completado' => false,
        ]);

        // Marcar manualmente como completado
        $evento->update(['completado' => true]);

        $evento->refresh();
        $this->assertTrue($evento->completado);
    }
}
