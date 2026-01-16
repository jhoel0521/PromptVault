@extends('components.usuario')

@section('title', 'Crear Nuevo Prompt - PromptVault')

@section('content')
<div class="min-h-screen bg-bgDark text-gray-200">
    <div class="max-w-3xl mx-auto px-6 py-10">
        
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('prompts.index') }}" class="bg-cardDark p-3 rounded-lg text-gray-400 hover:text-white border border-gray-700 transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-plus-circle text-primary"></i>
                    Crear Nuevo Prompt
                </h1>
                <p class="text-gray-400">Define las instrucciones para tu IA</p>
            </div>
        </div>

        {{-- Formulario --}}
        <div class="bg-cardDark border border-gray-800 rounded-xl p-8 shadow-2xl">
            <form action="{{ route('prompts.store') }}" method="POST">
                @csrf

                {{-- Título --}}
                <div class="mb-6">
                    <label for="titulo" class="block text-gray-300 text-sm font-bold mb-2">
                        Título del Prompt <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="titulo" 
                        id="titulo" 
                        class="w-full bg-bgDark border @error('titulo') border-red-500 @else border-gray-700 @enderror rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors placeholder-gray-500"
                        value="{{ old('titulo') }}"
                        placeholder="Ej: Generador de ideas de marketing"
                        required
                    >
                    @error('titulo')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="mb-6">
                    <label for="descripcion" class="block text-gray-300 text-sm font-bold mb-2">
                        Descripción Corta
                    </label>
                    <textarea 
                        name="descripcion" 
                        id="descripcion" 
                        rows="2" 
                        class="w-full bg-bgDark border @error('descripcion') border-red-500 @else border-gray-700 @enderror rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors placeholder-gray-500"
                        placeholder="Explica brevemente para qué sirve este prompt"
                    >{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contenido del Prompt --}}
                <div class="mb-6">
                    <label for="contenido" class="block text-gray-300 text-sm font-bold mb-2">
                        Contenido del Prompt <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="contenido" 
                        id="contenido" 
                        rows="10" 
                        class="w-full bg-bgDark border @error('contenido') border-red-500 @else border-gray-700 @enderror rounded-lg px-4 py-3 text-gray-300 font-mono text-sm focus:outline-none focus:border-primary transition-colors placeholder-gray-500"
                        placeholder="Escribe aquí las instrucciones detalladas para la IA..."
                        required
                    >{{ old('contenido') }}</textarea>
                    <small class="text-gray-500 block mt-2">Usa [CORCHETES] para indicar variables que el usuario debe completar.</small>
                    @error('contenido')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Modelo y Categoría --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="visibilidad" class="block text-gray-300 text-sm font-bold mb-2">
                            Visibilidad <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="visibilidad" 
                            id="visibilidad" 
                            class="w-full bg-bgDark border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors"
                            required
                        >
                            <option value="privado" {{ old('visibilidad') == 'privado' ? 'selected' : '' }}>Privado (Solo yo)</option>
                            <option value="publico" {{ old('visibilidad') == 'publico' ? 'selected' : '' }}>Público (Todo el sistema)</option>
                            <option value="enlace" {{ old('visibilidad') == 'enlace' ? 'selected' : '' }}>Por Enlace (Cualquiera con el link)</option>
                        </select>
                    </div>
                    <div>
                        <label for="etiquetas" class="block text-gray-300 text-sm font-bold mb-2">
                            Etiquetas
                        </label>
                        <select 
                            name="etiquetas_ids[]" 
                            id="etiquetas" 
                            class="w-full bg-bgDark border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors"
                            multiple
                            style="height: 120px;"
                        >
                            @foreach($etiquetas as $etiqueta)
                                <option 
                                    value="{{ $etiqueta->id }}" 
                                    {{ is_array(old('etiquetas_ids')) && in_array($etiqueta->id, old('etiquetas_ids')) ? 'selected' : '' }}
                                >
                                    {{ $etiqueta->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-gray-500 block mt-2">Mantén presionado Ctrl (Cmd en Mac) para seleccionar varias.</small>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-700">
                    <a 
                        href="{{ route('prompts.index') }}" 
                        class="text-gray-400 hover:text-white font-medium px-6 py-2 transition-colors"
                    >
                        Cancelar
                    </a>
                    <button 
                        type="submit" 
                        class="bg-primary hover:bg-rose-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-primary/20 transition-colors"
                    >
                        Guardar Prompt
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
