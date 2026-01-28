<?php

namespace Tests\Unit\Models;

use App\Models\Prompt;
use App\Models\Version;
use Tests\TestCase;

class VersionTest extends TestCase
{
    /**
     * Test que una versión pertenece a un prompt
     */
    public function test_version_belongs_to_prompt(): void
    {
        $version = Version::factory()->create();

        $this->assertNotNull($version->prompt);
        $this->assertInstanceOf(Prompt::class, $version->prompt);
    }

    /**
     * Test que una versión tiene un número de versión
     */
    public function test_version_has_numero_version(): void
    {
        $version = Version::factory()->create(['numero_version' => 5]);

        $this->assertEquals(5, $version->numero_version);
        $this->assertIsInt($version->numero_version);
    }
}
