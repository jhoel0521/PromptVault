{{-- Componente: Tarjeta de Prompt - Tailwind + Alpine --}}
@props(['prompt'])

<div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg h-full flex flex-col">
    <div class="flex justify-between items-start mb-4">
        <h5 class="text-lg font-bold text-slate-900 dark:text-slate-100 flex-1">
            <a href="{{ route('prompts.show', $prompt) }}" class="hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
                {{ $prompt->titulo }}
            </a>
        </h5>
        <span class="px-3 py-1 rounded-xl text-xs font-semibold whitespace-nowrap ml-2
                     {{ $prompt->visibilidad == 'publico' ? 'bg-emerald-500 text-white' : ($prompt->visibilidad == 'enlace' ? 'bg-amber-500 text-white' : 'bg-slate-500 text-white') }}">
            <i class="fas fa-{{ $prompt->visibilidad == 'publico' ? 'globe' : ($prompt->visibilidad == 'enlace' ? 'link' : 'lock') }}"></i>
            {{ ucfirst($prompt->visibilidad) }}
        </span>
    </div>
    
    <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-3 flex-1">
        {{ Str::limit($prompt->descripcion ?? $prompt->contenido, 120) }}
    </p>
    
    @if($prompt->etiquetas->count())
        <div class="mb-4 flex flex-wrap gap-2">
            @foreach($prompt->etiquetas->take(3) as $etiqueta)
                <span class="px-3 py-1 rounded-xl text-xs font-medium"
                      style="background-color: {{ $etiqueta->color_hex ?? '#6b7280' }}15; 
                             color: {{ $etiqueta->color_hex ?? '#6b7280' }}; 
                             border: 1px solid {{ $etiqueta->color_hex ?? '#6b7280' }}40;">
                    {{ $etiqueta->nombre }}
                </span>
            @endforeach
            @if($prompt->etiquetas->count() > 3)
                <span class="px-3 py-1 rounded-xl text-xs font-medium bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                    +{{ $prompt->etiquetas->count() - 3 }}
                </span>
            @endif
        </div>
    @endif
    
    <div class="flex justify-between items-center text-xs text-slate-500 dark:text-slate-400 border-t border-slate-200 dark:border-slate-700 pt-3">
        <div class="flex items-center gap-3">
            <span><i class="fas fa-eye"></i> {{ $prompt->conteo_vistas }}</span>
            <span><i class="fas fa-code-branch"></i> v{{ $prompt->version_actual }}</span>
            @if($prompt->promedio_calificacion > 0)
                <span class="text-amber-500"><i class="fas fa-star"></i> {{ number_format($prompt->promedio_calificacion, 1) }}</span>
            @endif
        </div>
        
        @auth
            <div class="flex gap-1">
                @can('update', $prompt)
                    <a href="{{ route('prompts.edit', $prompt) }}" 
                       class="px-2 py-1 rounded-md bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-200 dark:hover:bg-rose-900/50 transition-colors"
                       title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                @endcan
                <a href="{{ route('prompts.show', $prompt) }}" 
                   class="px-2 py-1 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors"
                   title="Ver">
                    <i class="fas fa-eye"></i>
                </a>
            </div>
        @endauth
    </div>
    
    @if($prompt->user)
        <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-rose-500 to-blue-500 flex items-center justify-center text-white font-bold text-xs">
                    {{ substr($prompt->user->name, 0, 1) }}
                </div>
                <span class="font-medium text-slate-700 dark:text-slate-300">{{ $prompt->user->name }}</span>
                <span class="ml-auto flex items-center gap-1">
                    <i class="fas fa-clock"></i> {{ $prompt->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    @endif
</div>
