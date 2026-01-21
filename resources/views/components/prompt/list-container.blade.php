{{-- Componente reutilizable: Contenedor de listado de prompts con filtros --}}
@props(['prompts', 'etiquetas', 'title', 'subtitle', 'emptyMessage', 'emptyIcon' => 'inbox', 'showCreate' => false, 'createRoute' => null])

<div class="max-w-7xl mx-auto px-6 py-10"
     x-data="{
        search: '',
        tag: '',
        matches(card) {
            const query = this.search.toLowerCase();
            const matchesSearch = !query || card.dataset.search.includes(query);
            const matchesTag = !this.tag || card.dataset.tags.split(',').includes(this.tag);
            return matchesSearch && matchesTag;
        }
     }">

    <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between mb-12">
        <div class="space-y-2">
            @if($title)
                <div class="inline-flex items-center gap-2 rounded-full bg-rose-100 text-rose-700 px-3 py-1 text-sm font-semibold dark:bg-rose-900/30 dark:text-rose-300">
                    <i class="fas fa-file-alt"></i>
                    <span>{{ $title }}</span>
                </div>
            @endif
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-slate-100">
                    {{ $slot }}
                </h1>
                @if($subtitle)
                    <p class="text-slate-500 dark:text-slate-400">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
        @if($showCreate && $createRoute)
            <a href="{{ $createRoute }}"
               class="inline-flex items-center gap-2 rounded-lg bg-rose-600 px-4 py-3 text-white font-semibold shadow-md shadow-rose-200 transition hover:bg-rose-700">
                <i class="fas fa-plus"></i>
                <span>Nuevo Prompt</span>
            </a>
        @endif
    </div>

    <div class="space-y-6 mb-12">
        <div class="relative max-w-2xl mx-auto">
            <input
                type="search"
                x-model="search"
                placeholder="Buscar prompt..."
                class="w-full rounded-full border border-slate-200 bg-white py-3 pl-11 pr-4 text-slate-800 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-100 dark:placeholder-slate-500">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500"></i>
        </div>

        @if($etiquetas->count())
            <div class="flex flex-wrap justify-center gap-2">
                <button
                    type="button"
                    @click="tag = ''"
                    :class="tag === '' ? 'bg-rose-100 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-300 dark:border-rose-700' : 'bg-white text-slate-500 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700'"
                    class="px-4 py-2 rounded-full text-sm border transition"
                >
                    Todas
                </button>
                @foreach($etiquetas as $etiqueta)
                    @php $tagName = strtolower($etiqueta->nombre); @endphp
                    <button
                        type="button"
                        @click="tag = tag === '{{ $tagName }}' ? '' : '{{ $tagName }}'"
                        :class="tag === '{{ $tagName }}' ? 'bg-rose-100 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-300 dark:border-rose-700' : 'bg-white text-slate-500 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700'"
                        class="px-4 py-2 rounded-full text-sm border transition"
                    >
                        #{{ $etiqueta->nombre }}
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse($prompts as $prompt)
            @php
                $tagNames = $prompt->etiquetas->pluck('nombre')->map(fn ($nombre) => strtolower($nombre))->implode(',');
                $searchText = strtolower(trim(preg_replace('/\s+/', ' ', implode(' ', [
                    $prompt->titulo,
                    $prompt->descripcion,
                    $prompt->contenido,
                    optional($prompt->user)->name,
                ]))));
            @endphp
            <div
                x-show="matches($el)"
                x-transition
                data-search="{{ $searchText }}"
                data-tags="{{ $tagNames }}"
            >
                <x-prompt.card :prompt="$prompt" />
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white border border-dashed border-slate-200 rounded-xl dark:bg-slate-800 dark:border-slate-700">
                <i class="fas fa-{{ $emptyIcon }} text-slate-300 dark:text-slate-600 text-5xl mb-4"></i>
                <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">{{ $emptyMessage }}</h3>
            </div>
        @endforelse
    </div>

</div>
