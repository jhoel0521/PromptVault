<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatbotConversacion extends Model
{
    protected $table = 'chatbot_conversaciones';

    protected $fillable = [
        'user_id',
        'question',
        'response',
        'provider',
        'model',
        'related_prompts',
    ];

    protected $casts = [
        'related_prompts' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
