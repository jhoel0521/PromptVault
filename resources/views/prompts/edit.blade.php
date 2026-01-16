@extends('components.usuario')

@section('title', 'Editar Prompt: ' . $prompt->titulo . ' - PromptVault')

@section('content')
<div class="min-h-screen text-[var(--text-dark)]">
    <div class="max-w-3xl mx-auto px-6 py-10">
        
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('prompts.show', $prompt) }}" class="bg-cardDark p-3 rounded-lg text-gray-400 hover:text-white border border-gray-700 transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-edit text-primary"></i>
                    Editar Prompt
                </h1>
                <p class="text-gray-400">Actualiza las instrucciones y configuración</p>
            </div>
        </div>

        {{-- Formulario --}}
        <div class="bg-[var(--light-bg)] border border-[var(--border-color)] rounded-xl p-8 shadow-2xl">
            <form action="{{ route('prompts.update', $prompt) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Título --}}
                <div class="mb-6">
                    <label for="titulo" class="block text-gray-300 text-sm font-bold mb-2">
                        Título del Prompt <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="titulo" 
                        id="titulo" 
                        class="w-full bg-[var(--input-bg)] border @error('titulo') border-red-500 @else border-[var(--border-color)] @enderror rounded-lg px-4 py-3 text-[var(--text-dark)] focus:outline-none focus:border-[var(--primary-red)] transition-colors"
                        value="{{ old('titulo', $prompt->titulo) }}"
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
                        class="w-full bg-[var(--input-bg)] border @error('descripcion') border-red-500 @else border-[var(--border-color)] @enderror rounded-lg px-4 py-3 text-[var(--text-dark)] focus:outline-none focus:border-[var(--primary-red)] transition-colors placeholder-[var(--text-muted)]"
                    >{{ old('descripcion', $prompt->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contenido del Prompt --}}
                <div class="mb-6">
                    <label for="contenido" class="block text-gray-300 text-sm font-bold mb-2">
                        Instrucciones (Prompt) <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="contenido" 
                        id="contenido" 
                        rows="10" 
                        class="w-full bg-[var(--input-bg)] border @error('contenido') border-red-500 @else border-[var(--border-color)] @enderror rounded-lg px-4 py-3 text-[var(--text-dark)] font-mono text-sm focus:outline-none focus:border-[var(--primary-red)] transition-colors"
                        required
                    >{{ old('contenido', $prompt->contenido) }}</textarea>
                    <small class="text-[var(--text-muted)] block mt-2">Usa [CORCHETES] para indicar variables. Se creará una nueva versión automáticamente.</small>
                    @error('contenido')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mensaje de cambio --}}
                <div class="mb-6">
                    <label for="mensaje_cambio" class="block text-gray-300 text-sm font-bold mb-2">
                        ¿Qué cambiaste? (Opcional)
                    </label>
                    <input 
                        type="text" 
                        name="mensaje_cambio" 
                        id="mensaje_cambio" 
                        class="w-full bg-[var(--input-bg)] border border-[var(--border-color)] rounded-lg px-4 py-3 text-[var(--text-dark)] focus:outline-none focus:border-[var(--primary-red)] transition-colors placeholder-[var(--text-muted)]"
                        placeholder="Ej: Mejoré la claridad de las instrucciones"
                    >
                </div>

                {{-- Visibilidad y Etiquetas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="visibilidad" class="block text-gray-300 text-sm font-bold mb-2">
                            Visibilidad <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="visibilidad" 
                            id="visibilidad" 
                            class="w-full bg-[var(--input-bg)] border border-[var(--border-color)] rounded-lg px-4 py-3 text-[var(--text-dark)] focus:outline-none focus:border-[var(--primary-red)] transition-colors"
                            required
                        >
                            <option value="privado" {{ old('visibilidad', $prompt->visibilidad) == 'privado' ? 'selected' : '' }}>Privado (Solo yo)</option>
                            <option value="publico" {{ old('visibilidad', $prompt->visibilidad) == 'publico' ? 'selected' : '' }}>Público (Todo el sistema)</option>
                            <option value="enlace" {{ old('visibilidad', $prompt->visibilidad) == 'enlace' ? 'selected' : '' }}>Por Enlace (Cualquiera con el link)</option>
                        </select>
                    </div>
                    <div>
                        <label for="etiquetas" class="block text-gray-300 text-sm font-bold mb-2">
                            Etiquetas
                        </label>
                        <select 
                            name="etiquetas_ids[]" 
                            id="etiquetas" 
                            class="w-full bg-[var(--input-bg)] border border-[var(--border-color)] rounded-lg px-4 py-3 text-[var(--text-dark)] focus:outline-none focus:border-[var(--primary-red)] transition-colors"
                            multiple
                            style="height: 120px;"
                        >
                            @foreach($etiquetas as $etiqueta)
                                <option 
                                    value="{{ $etiqueta->id }}" 
                                    {{ in_array($etiqueta->id, old('etiquetas_ids', $prompt->etiquetas->pluck('id')->toArray())) ? 'selected' : '' }}
                                >
                                    {{ $etiqueta->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-[var(--text-muted)] block mt-2">Mantén presionado Ctrl (Cmd en Mac) para seleccionar varias.</small>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-between pt-6 border-t border-[var(--border-color)]">
                    <button 
                        type="button"
                        onclick="confirmDelete()"
                        class="text-red-500 hover:text-red-400 font-medium px-4 py-2 transition-colors flex items-center gap-2"
                    >
                        <i class="fas fa-trash"></i> Eliminar Prompt
                    </button>

                    <div class="flex gap-4">
                        <a 
                            href="{{ route('prompts.show', $prompt) }}" 
                            class="text-[var(--text-muted)] hover:text-[var(--text-dark)] font-medium px-6 py-2 transition-colors"
                        >
                            Cancelar
                        </a>
                        <button 
                            type="submit" 
                            class="bg-[var(--primary-red)] hover:bg-[var(--primary-red-hover)] text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-primary/20 transition-colors"
                        >
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>

            {{-- Delete Form (Hidden) --}}
            <form id="deleteForm" action="{{ route('prompts.destroy', $prompt) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm('¿Estás seguro de que deseas eliminar este prompt? Esta acción no se puede deshacer.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endsection
