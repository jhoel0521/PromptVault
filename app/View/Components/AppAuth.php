<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppAuth extends Component
{
    public string $title;

    public string $description;

    public string $brandingTitle;

    public string $brandingText;

    public function __construct(
        string $title = 'PromptVault',
        string $description = '',
        string $brandingTitle = 'GESTIONA TUS PROMPTS CON INTELIGENCIA',
        string $brandingText = 'Sistema de gestión centralizada de prompts de IA con versionado automático, colaboración en tiempo real y organización inteligente por categorías y etiquetas.'
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->brandingTitle = $brandingTitle;
        $this->brandingText = $brandingText;
    }

    public function render()
    {
        return view('layouts.app-auth');
    }
}
