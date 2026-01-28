<?php

namespace Tests\Unit\Services;

use App\Models\AppSetting;
use App\Services\ConfigurationService;
use Tests\TestCase;

class ConfigurationServiceTest extends TestCase
{
    private ConfigurationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(ConfigurationService::class);
    }

    /**
     * Test que obtener configuracion devuelve AppSetting
     */
    public function test_obtener_configuracion_devuelve_app_settings(): void
    {
        // Crear configuración inicial
        $settings = AppSetting::firstOrCreate([], [
            'app_name' => 'PromptVault Test',
            'support_email' => 'test@example.com',
            'maintenance_mode' => false,
        ]);

        // Obtener settings
        $resultado = $this->service->getSettings();

        $this->assertInstanceOf(AppSetting::class, $resultado);
        $this->assertEquals('PromptVault Test', $resultado->app_name);
        $this->assertEquals('test@example.com', $resultado->support_email);
        $this->assertFalse($resultado->maintenance_mode);
        $this->assertEquals($settings->id, $resultado->id);
    }

    /**
     * Test que actualizar configuracion persiste cambios
     */
    public function test_actualizar_configuracion_persiste_cambios(): void
    {
        // Crear configuración inicial
        AppSetting::firstOrCreate([], [
            'app_name' => 'PromptVault Original',
            'support_email' => 'original@example.com',
            'maintenance_mode' => false,
            'two_fa_enabled' => false,
        ]);

        // Actualizar settings
        $data = [
            'app_name' => 'PromptVault Actualizado',
            'support_email' => 'nuevo@example.com',
            'maintenance_mode' => true,
            'two_fa_enabled' => true,
        ];

        $resultado = $this->service->updateSettings($data);

        // Validar resultado
        $this->assertInstanceOf(AppSetting::class, $resultado);
        $this->assertEquals('PromptVault Actualizado', $resultado->app_name);
        $this->assertEquals('nuevo@example.com', $resultado->support_email);
        $this->assertTrue($resultado->maintenance_mode);
        $this->assertTrue($resultado->two_fa_enabled);

        // Validar persistencia en base de datos
        $this->assertDatabaseHas('app_settings', [
            'app_name' => 'PromptVault Actualizado',
            'support_email' => 'nuevo@example.com',
            'maintenance_mode' => true,
            'two_fa_enabled' => true,
        ]);

        // Validar que solo existe un registro
        $this->assertEquals(1, AppSetting::count());
    }
}
