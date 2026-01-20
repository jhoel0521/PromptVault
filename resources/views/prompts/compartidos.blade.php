<x-app-layout :title="'Compartidos Conmigo - PromptVault'">
    <div class="max-w-7xl mx-auto px-6 py-10">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                <i class="fas fa-share-alt text-rose-600"></i> 
                Compartidos Conmigo
            </h1>
            <p class="text-slate-600 dark:text-slate-400 mt-2">
                Prompts a los que otros usuarios te han dado acceso
            </p>
        </div>

        {{-- Filtros (sin visibilidad) --}}
        <div class="mb-6">
            <x-prompt.filters :etiquetas="collect()" :showVisibility="false" />
        </div>

        {{-- Grid de prompts --}}
        <x-prompt.grid 
            :prompts="$prompts" 
            emptyMessage="No te han compartido ningún prompt todavía" 
            emptyIcon="share-alt"
        />
    </div>
</x-app-layout>
