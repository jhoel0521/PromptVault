<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Version extends Model
{
    use HasFactory;

    protected $table = 'versiones';

    protected $fillable = [
        'prompt_id',
        'numero_version',
        'contenido',
        'mensaje_cambio',
    ];

    protected $casts = [
        'numero_version' => 'integer',
    ];

    public function prompt(): BelongsTo
    {
        return $this->belongsTo(Prompt::class);
    }
}
