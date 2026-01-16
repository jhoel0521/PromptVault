@extends('components.usuario')

@section('title', 'Mis Prompts - PromptVault')

@section('content')
<div class="min-h-screen bg-bgDark text-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-10">
        
        {{-- Header --}}
        <div class="flex justify-between items-start mb-12">
            <div>
                <h1 class="text-4xl font-bold text-white mb-2 flex items-center gap-3">
                    <i class="fas fa-file-alt text-primary text-3xl"></i>
                    Biblioteca de Prompts
                </h1>
                <p class="text-gray-400">Gestiona y organiza tus prompts personales</p>
            </div>
            <a href="{{ route('prompts.create') }}" class="bg-primary hover:bg-rose-600 text-white px-6 py-3 rounded-lg font-bold transition-colors shadow-lg shadow-primary/20 flex items-center gap-2">
                <i class="fas fa-plus"></i> Nuevo Prompt
            </a>
        </div>

        {{-- Buscador --}}
        <div class="text-center mb-12">
            <div class="relative max-w-xl mx-auto mb-6">
                <input 
                    type="text" 
                    id="searchInput"
                    placeholder="Buscar prompt..." 
                    class="w-full bg-cardDark border border-gray-700 rounded-full py-3 px-10 text-white focus:outline-none focus:border-primary transition-colors placeholder-gray-500"
                >
                <i class="fas fa-search absolute left-4 top-4 text-gray-500"></i>
            </div>
            
            {{-- Etiquetas --}}
            @if($etiquetas->count())
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach($etiquetas as $etiqueta)
                        <button 
                            type="button"
                            onclick="filterByTag('{{ $etiqueta->nombre }}')"
                            class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-full text-sm text-gray-300 border border-gray-700 transition-colors"
                            style="border-color: {{ $etiqueta->color_hex ?? '#4b5563' }}40; color: {{ $etiqueta->color_hex ?? '#9ca3af' }}"
                        >
                            #{{ $etiqueta->nombre }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Grid de Tarjetas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="promptsGrid">
            @forelse($prompts as $prompt)
                <a href="{{ route('prompts.show', $prompt) }}" class="block bg-cardDark border border-gray-800 rounded-xl p-6 hover:border-primary/50 transition-all hover:-translate-y-1 group">
                    <div class="flex justify-between items-start mb-4">
                        <span class="bg-blue-900/30 text-blue-400 text-xs px-2 py-1 rounded border border-blue-800">
                            {{ $prompt->titulo }}
                        </span>
                        @if($prompt->promedio_calificacion)
                            <span class="text-yellow-500 text-sm flex items-center gap-1">
                                <i class="fas fa-star"></i> {{ number_format($prompt->promedio_calificacion, 1) }}
                            </span>
                        @endif
                    </div>
                    
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-primary transition-colors line-clamp-2">
                        {{ $prompt->titulo }}
                    </h3>
                    
                    <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                        {{ $prompt->descripcion ?? 'Sin descripción' }}
                    </p>

                    @if($prompt->etiquetas->count())
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($prompt->etiquetas->take(2) as $etiqueta)
                                <span 
                                    class="text-xs px-2 py-1 rounded-full text-white"
                                    style="background-color: {{ $etiqueta->color_hex ?? '#6c757d' }}40; color: {{ $etiqueta->color_hex ?? '#6c757d' }}"
                                >
                                    {{ $etiqueta->nombre }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="flex items-center gap-2 text-xs text-gray-500 border-t border-gray-700 pt-3">
                        <div class="w-5 h-5 rounded-full bg-gradient-to-tr from-purple-600 to-blue-500 flex items-center justify-center text-white font-bold text-xs">
                            {{ substr($prompt->user->name, 0, 1) }}
                        </div>
                        <span>{{ $prompt->user->name }}</span>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-inbox text-gray-600 text-5xl mb-4"></i>
                    <h3 class="text-xl font-bold text-white mb-2">No tienes prompts todavía</h3>
                    <p class="text-gray-400 mb-6">Crea tu primer prompt para empezar a gestionar tus instrucciones de IA</p>
                    <a href="{{ route('prompts.create') }}" class="bg-primary hover:bg-rose-600 text-white px-6 py-2 rounded-lg font-bold transition-colors inline-flex items-center gap-2">
                        <i class="fas fa-plus"></i> Crear Primer Prompt
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function filterByTag(tag) {
        const grid = document.getElementById('promptsGrid');
        const cards = grid.querySelectorAll('a');
        
        cards.forEach(card => {
            const hasTag = card.textContent.includes(`#${tag}`);
            card.style.display = hasTag ? 'block' : 'none';
        });
    }

    document.getElementById('searchInput')?.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const grid = document.getElementById('promptsGrid');
        const cards = grid.querySelectorAll('a');
        
        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });
    });
</script>
@endsection
