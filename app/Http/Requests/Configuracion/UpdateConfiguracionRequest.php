<?php

namespace App\Http\Requests\Configuracion;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConfiguracionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->esAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'app_name' => 'required|string|max:255',
            'app_url' => 'nullable|url',
            'app_env' => 'nullable|string|max:50',
            'app_locale' => 'nullable|string|max:10',
            'app_fallback_locale' => 'nullable|string|max:10',
            'support_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'maintenance_mode' => 'nullable|boolean',
            'theme' => 'nullable|in:dark,light',
            'language' => 'nullable|in:es,en',
            'mail_mailer' => 'nullable|string|max:50',
            'mail_host' => 'nullable|string|max:150',
            'mail_port' => 'nullable|integer',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string|max:150',
            'session_driver' => 'nullable|string|max:50',
            'cache_store' => 'nullable|string|max:50',
            'queue_connection' => 'nullable|string|max:50',
            // Seguridad - Políticas de Acceso
            'two_fa_enabled' => 'nullable|boolean',
            'session_timeout' => 'nullable|integer|min:5|max:1440',
            'max_login_attempts' => 'nullable|integer|min:1|max:20',
            'geo_blocking_enabled' => 'nullable|boolean',
            // Seguridad - Contraseñas
            'password_min_length' => 'nullable|integer|min:8|max:32',
            'password_expiry_days' => 'nullable|integer|min:1|max:365',
            'password_require_special_chars' => 'nullable|boolean',
            'password_force_rotation' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'app_name' => 'nombre de la aplicación',
            'support_email' => 'email de soporte',
            'contact_phone' => 'teléfono de contacto',
            'session_timeout' => 'tiempo de sesión',
            'max_login_attempts' => 'intentos máximos de login',
            'password_min_length' => 'longitud mínima de contraseña',
            'password_expiry_days' => 'días de expiración de contraseña',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convertir checkboxes a booleanos (no enviados = false)
        $this->merge([
            'maintenance_mode' => $this->boolean('maintenance_mode'),
            'two_fa_enabled' => $this->boolean('two_fa_enabled'),
            'geo_blocking_enabled' => $this->boolean('geo_blocking_enabled'),
            'password_require_special_chars' => $this->boolean('password_require_special_chars'),
            'password_force_rotation' => $this->boolean('password_force_rotation'),
        ]);
    }
}
