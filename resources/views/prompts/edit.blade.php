<x-app-layout :title="'Editar Prompt: ' . $prompt->titulo . ' - PromptVault'">
    <div class="max-w-3xl mx-auto px-6 py-10">
        
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('prompts.show', $prompt) }}" 
               class="bg-white dark:bg-slate-800 p-3 rounded-lg text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white border border-slate-200 dark:border-slate-700 transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                    <i class="fas fa-edit text-rose-600"></i>
                    Editar Prompt
                </h1>
                <p class="text-slate-600 dark:text-slate-400">Actualiza las instrucciones y configuración</p>
            </div>
        </div>

        {{-- Formulario --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-8 shadow-lg">
            <form action="{{ route('prompts.update', $prompt) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Título --}}
                <div class="mb-6">
                    <label for="titulo" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                        Título del Prompt <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="titulo" 
                        id="titulo" 
                        class="w-full bg-white dark:bg-slate-900 border @error('titulo') border-red-500 @else border-slate-300 dark:border-slate-600 @enderror rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors"
                        value="{{ old('titulo', $prompt->titulo) }}"
                        required
                    >
                    @error('titulo')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="mb-6">
                    <label for="descripcion" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                        Descripción Corta
                    </label>
                    <textarea 
                        name="descripcion" 
                        id="descripcion" 
                        rows="2" 
                        class="w-full bg-white dark:bg-slate-900 border @error('descripcion') border-red-500 @else border-slate-300 dark:border-slate-600 @enderror rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors placeholder-slate-400 dark:placeholder-slate-500"
                    >{{ old('descripcion', $prompt->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contenido del Prompt --}}
                <div class="mb-6">
                    <label for="contenido" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                        Instrucciones (Prompt) <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="contenido" 
                        id="contenido" 
                        rows="10" 
                        class="w-full bg-white dark:bg-slate-900 border @error('contenido') border-red-500 @else border-slate-300 dark:border-slate-600 @enderror rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 font-mono text-sm focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors"
                        required
                    >{{ old('contenido', $prompt->contenido) }}</textarea>
                    <small class="text-slate-500 dark:text-slate-400 block mt-2">Usa [CORCHETES] para indicar variables. Se creará una nueva versión automáticamente.</small>
                    @error('contenido')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mensaje de cambio --}}
                <div class="mb-6">
                    <label for="mensaje_cambio" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                        ¿Qué cambiaste? (Opcional)
                    </label>
                    <input 
                        type="text" 
                        name="mensaje_cambio" 
                        id="mensaje_cambio" 
                        class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors placeholder-slate-400 dark:placeholder-slate-500"
                        placeholder="Ej: Mejoré la claridad de las instrucciones"
                    >
                </div>

                {{-- Visibilidad y Etiquetas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="visibilidad" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                            Visibilidad <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="visibilidad" 
                            id="visibilidad" 
                            class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors"
                            required
                        >
                            <option value="privado" {{ old('visibilidad', $prompt->visibilidad) == 'privado' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Privado (Solo yo)</option>
                            <option value="publico" {{ old('visibilidad', $prompt->visibilidad) == 'publico' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Público (Todo el sistema)</option>
                            <option value="enlace" {{ old('visibilidad', $prompt->visibilidad) == 'enlace' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Por Enlace (Cualquiera con el link)</option>
                        </select>
                    </div>
                    <div>
                        <label for="etiquetas" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                            Etiquetas
                        </label>
                        <select 
                            name="etiquetas_ids[]" 
                            id="etiquetas" 
                            class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors"
                            multiple
                            style="height: 120px;"
                        >
                            @foreach($etiquetas as $etiqueta)
                                <option 
                                    value="{{ $etiqueta->id }}" 
                                    class="bg-white dark:bg-slate-900"
                                    {{ in_array($etiqueta->id, old('etiquetas_ids', $prompt->etiquetas->pluck('id')->toArray())) ? 'selected' : '' }}
                                >
                                    {{ $etiqueta->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-slate-500 dark:text-slate-400 block mt-2">Mantén presionado Ctrl (Cmd en Mac) para seleccionar varias.</small>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-700">
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
                            class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-medium px-6 py-2 transition-colors"
                        >
                            Cancelar
                        </a>
                        <button 
                            type="submit" 
                            class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-rose-500/20 transition-colors"
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

<script>
    function confirmDelete() {
        if (confirm('¿Estás seguro de que deseas eliminar este prompt? Esta acción no se puede deshacer.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
</x-app-layout>
