<?php

namespace App\Http\Requests\Prompt;

use Illuminate\Foundation\Http\FormRequest;

class RatePromptRequest extends FormRequest
{
    public function authorize(): bool
    {
        $prompt = $this->route('prompt');

        return $this->user()?->can('rate', $prompt) ?? false;
    }

    public function rules(): array
    {
        return [
            'estrellas' => 'required|integer|min:1|max:5',
            'resena' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'estrellas.required' => 'Selecciona una calificación entre 1 y 5 estrellas.',
            'estrellas.integer' => 'La calificación debe ser un número entero.',
            'estrellas.min' => 'La calificación mínima es 1 estrella.',
            'estrellas.max' => 'La calificación máxima es 5 estrellas.',
            'resena.max' => 'La reseña no puede exceder 255 caracteres.',
        ];
    }
}
