<?php

namespace App\Providers;

use App\Models\Comentario;
use App\Models\Prompt;
use App\Policies\ComentarioPolicy;
use App\Policies\PromptPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Prompt::class => PromptPolicy::class,
        Comentario::class => ComentarioPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
