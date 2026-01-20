<x-app-layout :title="'Mis Prompts - PromptVault'">
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
                <div class="inline-flex items-center gap-2 rounded-full bg-rose-100 text-rose-700 px-3 py-1 text-sm font-semibold dark:bg-rose-900/30 dark:text-rose-300">
                    <i class="fas fa-file-alt"></i>
                    <span>Biblioteca de Prompts</span>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-slate-100">Mis Prompts</h1>
                    <p class="text-slate-500 dark:text-slate-400">Gestiona y organiza tus prompts personales</p>
                </div>
            </div>
            <a href="{{ route('prompts.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-rose-600 px-4 py-3 text-white font-semibold shadow-md shadow-rose-200 transition hover:bg-rose-700">
                <i class="fas fa-plus"></i>
                <span>Nuevo Prompt</span>
            </a>
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
                    $searchIndex = strtolower($prompt->titulo.' '.($prompt->descripcion ?? '').' '.$prompt->etiquetas->pluck('nombre')->implode(' '));
                    $tagList = $prompt->etiquetas->pluck('nombre')->map(fn($name) => strtolower($name))->implode(',');
                @endphp
                <a
                    href="{{ route('prompts.show', $prompt) }}"
                    data-search="{{ $searchIndex }}"
                    data-tags="{{ $tagList }}"
                    x-show="matches($el)"
                    class="block rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-rose-200 hover:shadow-md dark:bg-slate-800 dark:border-slate-700 dark:hover:border-rose-600"
                >
                    <div class="flex items-start justify-between mb-4">
                        <span class="inline-flex items-center gap-2 rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                            {{ $prompt->titulo }}
                        </span>
                        @if($prompt->promedio_calificacion)
                            <span class="text-amber-500 text-sm font-semibold flex items-center gap-1">
                                <i class="fas fa-star"></i>
                                {{ number_format($prompt->promedio_calificacion, 1) }}
                            </span>
                        @endif
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 mb-2 line-clamp-2">
                        {{ $prompt->titulo }}
                    </h3>

                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-4 line-clamp-2">
                        {{ $prompt->descripcion ?? 'Sin descripcion' }}
                    </p>

                    @if($prompt->etiquetas->count())
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($prompt->etiquetas->take(2) as $etiqueta)
                                @php $color = $etiqueta->color_hex ?? '#6b7280'; @endphp
                                <span
                                    class="text-xs px-2 py-1 rounded-full border"
                                    style="background-color: {{ $color }}15; color: {{ $color }}; border-color: {{ $color }}40;"
                                >
                                    {{ $etiqueta->nombre }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 border-t border-slate-200 dark:border-slate-700 pt-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-rose-500 to-blue-500 flex items-center justify-center text-white font-bold">
                            {{ substr($prompt->user->name, 0, 1) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $prompt->user->name }}</span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400">{{ $prompt->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 bg-white border border-dashed border-slate-200 rounded-xl dark:bg-slate-800 dark:border-slate-700">
                    <i class="fas fa-inbox text-slate-300 dark:text-slate-600 text-5xl mb-4"></i>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">No tienes prompts todavia</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-6">Crea tu primer prompt para empezar a gestionar tus instrucciones de IA</p>
                    <a href="{{ route('prompts.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-rose-600 px-4 py-2 text-white font-semibold shadow-sm transition hover:bg-rose-700">
                        <i class="fas fa-plus"></i> Crear Primer Prompt
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
