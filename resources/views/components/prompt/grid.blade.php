{{-- Componente: Grid de Prompts - Tailwind --}}
@props(['prompts', 'emptyMessage' => 'No hay prompts disponibles', 'emptyIcon' => 'inbox'])

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($prompts as $prompt)
        <x-prompt.card :prompt="$prompt" />
    @empty
        <div class="col-span-full text-center py-16">
            <i class="fas fa-{{ $emptyIcon }} text-6xl text-slate-300 dark:text-slate-600 opacity-50 mb-4"></i>
            <h4 class="text-xl font-bold text-slate-400 dark:text-slate-500 mb-2">{{ $emptyMessage }}</h4>
            @auth
                @if(request()->routeIs('prompts.index'))
                    <p class="text-slate-500 dark:text-slate-400 mb-6">Crea tu primer prompt para comenzar</p>
                    <a href="{{ route('prompts.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-rose-600 text-white font-semibold hover:bg-rose-700 transition-colors">
                        <i class="fas fa-plus"></i> Crear Prompt
                    </a>
                @endif
            @else
                <p class="text-slate-500 dark:text-slate-400 mb-4">Inicia sesión para ver más contenido</p>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-rose-600 text-white font-semibold hover:bg-rose-700 transition-colors">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
            @endauth
        </div>
    @endforelse
</div>

@if($prompts->hasPages())
    <div class="mt-8 flex justify-center gap-2">
        @if ($prompts->onFirstPage())
            <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-600 cursor-not-allowed">Anterior</span>
        @else
            <a href="{{ $prompts->previousPageUrl() }}" 
               class="px-4 py-2 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition-colors">
                Anterior
            </a>
        @endif
        
        <span class="px-4 py-2 rounded-lg bg-rose-600 text-white font-semibold">
            Página {{ $prompts->currentPage() }} de {{ $prompts->lastPage() }}
        </span>
        
        @if ($prompts->hasMorePages())
            <a href="{{ $prompts->nextPageUrl() }}" 
               class="px-4 py-2 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition-colors">
                Siguiente
            </a>
        @else
            <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-600 cursor-not-allowed">Siguiente</span>
        @endif
    </div>
@endif
