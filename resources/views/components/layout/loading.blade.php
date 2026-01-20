{{-- Loading overlay - Alpine --}}
<div x-data="{ show: false, progress: 0 }" x-show="show" x-transition.opacity
    class="fixed inset-0 z-50 bg-slate-900/90 flex items-center justify-center">
    <div
        class="max-w-xs w-full px-6 py-5 bg-slate-950 border border-red-500/40 rounded-2xl shadow-2xl text-center text-white space-y-4">
        <div class="flex justify-center">
            <svg class="w-10 h-10 text-red-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke-width="2" opacity="0.25" />
                <path d="M12 2a10 10 0 0 1 10 10" stroke-width="2" />
            </svg>
        </div>
        <div>
            <p class="text-lg font-semibold">Cargando...</p>
            <p class="text-xs text-slate-300">Preparando tu experiencia</p>
        </div>
        <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden">
            <div class="h-full bg-red-500" :style="`width:${progress}%`"></div>
        </div>
    </div>
</div>

<script>
    window.showLoader = () => {
        const el = document.querySelector('[x-data]')?.__x?.$data;
        const overlay = document.getElementById('loadingOverlay');
    }
</script>
