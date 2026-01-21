<?php

namespace App\Http\Requests\Traits;

use App\Models\AppSetting;

trait ValidatePasswordPolicies
{
    /**
     * Obtiene las reglas de validación de contraseña según las políticas de la app
     */
    protected function getPasswordRules(): array
    {
        $settings = AppSetting::getSettings();
        $rules = ['required', 'string', 'min:'.$settings->password_min_length, 'confirmed'];

        if ($settings->password_require_special_chars) {
            $rules[] = 'regex:/^(?=.*[!@#$%^&*()_+\-=\[\]{};:\'",.<>?\/\\|`~]).*$/';
        }

        return $rules;
    }

    /**
     * Obtiene los mensajes personalizados para validación de contraseña
     */
    protected function getPasswordMessages(): array
    {
        $settings = AppSetting::getSettings();

        return [
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => "La contraseña debe tener al menos {$settings->password_min_length} caracteres",
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.regex' => 'La contraseña debe contener caracteres especiales (!@#$%^&*)',
        ];
    }
}
