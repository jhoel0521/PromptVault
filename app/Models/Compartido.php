<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compartido extends Model
{
    protected $fillable = [
        'prompt_id',
        'nombre_destinatario',
        'email_destinatario',
        'fecha_compartido',
        'notas'
    ];

    protected $casts = [
        'fecha_compartido' => 'datetime'
    ];

    public function prompt(): BelongsTo
    {
        return $this->belongsTo(Prompt::class);
    }
}
