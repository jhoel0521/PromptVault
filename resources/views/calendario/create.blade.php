<x-app-layout :title="'Crear Evento - PromptVault'">
    <div class="max-w-4xl mx-auto px-6 py-8">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                    <i class="fas fa-calendar-plus text-rose-600"></i>
                    Crear Nuevo Evento
                </h1>
                <p class="text-slate-600 dark:text-slate-400 mt-2">Agrega un nuevo evento al calendario académico</p>
            </div>
            <a href="{{ route('calendario.index') }}" 
               class="bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-medium px-6 py-3 rounded-lg border border-slate-200 dark:border-slate-700 transition-colors flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        {{-- Formulario --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-8 shadow-lg">
            <form action="{{ route('calendario.store') }}" method="POST" id="createEventoForm">
                @csrf
                
                {{-- Título del Evento --}}
                <div class="mb-6">
                    <label for="titulo" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                        Título del Evento <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="titulo" 
                        id="titulo" 
                        class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors"
                        required
                    >
                </div>

                {{-- Descripción --}}
                <div class="mb-6">
                    <label for="descripcion" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                        Descripción
                    </label>
                    <textarea 
                        name="descripcion" 
                        id="descripcion" 
                        rows="3" 
                        class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors"
                    ></textarea>
                </div>

                {{-- Fecha y Hora --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="fecha_inicio" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                            Fecha y Hora de Inicio <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="datetime-local" 
                            name="fecha_inicio" 
                            id="fecha_inicio" 
                            class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors"
                            value="{{ old('fecha_inicio') }}"
                            required
                        >
                    </div>
                    <div>
                        <label for="fecha_fin" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                            Fecha y Hora de Fin
                        </label>
                        <input 
                            type="datetime-local" 
                            name="fecha_fin" 
                            id="fecha_fin" 
                            class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors"
                            value="{{ old('fecha_fin') }}"
                        >
                    </div>
                </div>

                {{-- Tipo y Ubicación --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="tipo" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                            Tipo de Evento <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="tipo" 
                            id="tipo" 
                            class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors"
                            required
                        >
                            <option value="" class="bg-white dark:bg-slate-900">Selecciona un tipo</option>
                            @foreach(App\Enums\TipoEvento::cases() as $tipo)
                                <option value="{{ $tipo->value }}" class="bg-white dark:bg-slate-900" {{ old('tipo') == $tipo->value ? 'selected' : '' }}>
                                    {{ ucfirst($tipo->value) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="ubicacion" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
                            Ubicación
                        </label>
                        <input 
                            type="text" 
                            name="ubicacion" 
                            id="ubicacion" 
                            class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-3 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors"
                            placeholder="Ej: Sala 101, Auditorio, Virtual"
                            value="{{ old('ubicacion') }}"
                        >
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <a 
                        href="{{ route('calendario.index') }}" 
                        class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-medium px-6 py-2 transition-colors"
                    >
                        Cancelar
                    </a>
                    <button 
                        type="submit" 
                        class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-rose-500/20 transition-colors"
                    >
                        Crear Evento
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>