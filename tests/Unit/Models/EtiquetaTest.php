<?php

namespace Tests\Unit\Models;

use App\Models\Etiqueta;
use App\Models\Prompt;
use Tests\TestCase;

class EtiquetaTest extends TestCase
{
    /**
     * Test que una etiqueta tiene muchos prompts (many-to-many)
     */
    public function test_etiqueta_has_many_prompts(): void
    {
        $etiqueta = Etiqueta::factory()->create();
        $prompts = Prompt::factory(3)->create();

        foreach ($prompts as $prompt) {
            $etiqueta->prompts()->attach($prompt->id);
        }

        $this->assertEquals(3, $etiqueta->prompts()->count());
    }

    /**
     * Test que se pueden filtrar prompts por etiqueta
     */
    public function test_filter_prompts_by_etiqueta(): void
    {
        $etiqueta = Etiqueta::factory()->create(['nombre' => 'JavaScript']);
        $prompt1 = Prompt::factory()->create();
        $prompt2 = Prompt::factory()->create();

        $prompt1->etiquetas()->attach($etiqueta->id);
        $prompt2->etiquetas()->attach($etiqueta->id);

        $filtered = Prompt::whereHas('etiquetas', function ($query) use ($etiqueta) {
            $query->where('etiquetas.id', $etiqueta->id);
        })->get();

        $this->assertEquals(2, $filtered->count());
        $this->assertTrue($filtered->contains($prompt1));
        $this->assertTrue($filtered->contains($prompt2));
    }
}
