<?php

namespace Tests\Feature\Admin;

use App\Models\AppSetting;
use App\Models\User;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    /**
     * Test que admin puede ver configuraciones
     */
    public function test_admin_puede_ver_configuraciones(): void
    {
        $admin = User::factory()->create();
        $admin->update(['role_id' => 1]); // Admin role

        $response = $this->actingAs($admin)->get(route('admin.configuraciones.general'));

        $response->assertStatus(200);
        $response->assertViewIs('configuraciones.general');
    }

    /**
     * Test que admin puede actualizar configuraciones
     */
    public function test_admin_puede_actualizar_configuraciones(): void
    {
        $admin = User::factory()->create();
        $admin->update(['role_id' => 1]); // Admin role

        // Crear configuración inicial si no existe
        AppSetting::firstOrCreate([], [
            'app_name' => 'PromptVault',
            'maintenance_mode' => false,
        ]);

        // Actualizar configuración
        $response = $this->actingAs($admin)->post(
            route('admin.configuraciones.update'),
            [
                'app_name' => 'PromptVault Testing',
                'support_email' => 'test@example.com',
                'maintenance_mode' => false,
            ]
        );

        $response->assertRedirect();

        // Validar que se guardaron en app_settings
        $this->assertDatabaseHas('app_settings', [
            'app_name' => 'PromptVault Testing',
            'support_email' => 'test@example.com',
        ]);
    }

    /**
     * Test que non-admin no puede acceder a configuraciones
     */
    public function test_no_admin_no_puede_acceder_configuraciones(): void
    {
        $user = User::factory()->create();
        $user->update(['role_id' => 2]); // Usuario normal

        // Intentar ver configuración general
        $response = $this->actingAs($user)->get(route('admin.configuraciones.general'));
        $response->assertStatus(403);

        // Intentar actualizar configuraciones
        $response = $this->actingAs($user)->post(
            route('admin.configuraciones.update'),
            [
                'app_nombre' => 'Intento de cambio',
            ]
        );
        $response->assertStatus(403);
    }
}
