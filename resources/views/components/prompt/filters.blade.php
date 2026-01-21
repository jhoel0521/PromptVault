{{-- Componente: Filtros de Prompts --}}
@props(['etiquetas', 'showVisibility' => true])

<form action="{{ route('home') }}" method="GET" class="grid gap-3 mb-8" style="grid-template-columns: 2fr 1fr 1fr 1fr auto;">
    <div>
        <input 
            type="text" 
            name="buscar" 
            placeholder="Buscar por título o contenido..." 
            value="{{ request('buscar') }}"
            class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-rose-500/20 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400 focus:border-rose-500"
        >
    </div>
    
    @if($showVisibility)
        <div>
            <select name="visibilidad" 
                    class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-rose-500/20 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-rose-500">
                <option value="" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">Todas las visibilidades</option>
                <option value="privado" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100" {{ request('visibilidad') == 'privado' ? 'selected' : '' }}>Privado</option>
                <option value="publico" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100" {{ request('visibilidad') == 'publico' ? 'selected' : '' }}>Público</option>
                <option value="enlace" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100" {{ request('visibilidad') == 'enlace' ? 'selected' : '' }}>Por enlace</option>
            </select>
        </div>
    @endif
    
    <div>
        <select name="etiqueta" 
                class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-rose-500/20 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-rose-500">
            <option value="" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">Todas las etiquetas</option>
            @foreach($etiquetas as $etiqueta)
                <option value="{{ $etiqueta->nombre }}" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100" {{ request('etiqueta') == $etiqueta->nombre ? 'selected' : '' }}>
                    {{ $etiqueta->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div>
        <select name="orden" 
                class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-rose-500/20 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:border-rose-500">
            <option value="reciente" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100" {{ request('orden', 'reciente') == 'reciente' ? 'selected' : '' }}>Más recientes</option>
            <option value="titulo" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100" {{ request('orden') == 'titulo' ? 'selected' : '' }}>Por título</option>
            <option value="vistas" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100" {{ request('orden') == 'vistas' ? 'selected' : '' }}>Más vistos</option>
            <option value="calificacion" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100" {{ request('orden') == 'calificacion' ? 'selected' : '' }}>Mejor valorados</option>
        </select>
    </div>
    
    <div>
        <button type="submit" 
                class="px-6 py-3 rounded-lg bg-rose-600 text-white font-semibold hover:bg-rose-700 transition whitespace-nowrap">
            <i class="fas fa-filter"></i> Filtrar
        </button>
    </div>
</form>
