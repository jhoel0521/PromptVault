<?php

namespace App\Contracts\Services;

use App\Models\AccesoCompartido;
use App\Models\Prompt;
use App\Models\User;

interface CompartirServiceInterface
{
    /**
     * Compartir prompt con un usuario
     */
    public function compartir(Prompt $prompt, User $usuario, string $nivelAcceso): AccesoCompartido;

    /**
     * Quitar acceso a un usuario
     */
    public function quitarAcceso(Prompt $prompt, User $usuario): bool;

    /**
     * Verificar nivel de acceso de un usuario a un prompt
     *
     * @return string|null 'propietario', 'editor', 'comentador', 'lector', o null
     */
    public function verificarAcceso(Prompt $prompt, ?User $usuario): ?string;

    /**
     * Verificar si usuario puede editar
     */
    public function puedeEditar(Prompt $prompt, ?User $usuario): bool;

    /**
     * Verificar si usuario puede comentar
     */
    public function puedeComentar(Prompt $prompt, ?User $usuario): bool;
}
