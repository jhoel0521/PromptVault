<x-guest-layout>
    <x-slot:title>404 - Página No Encontrada | PromptVault</x-slot:title>

    <div x-data="{
        logs: [
            '> Searching database...',
            '> Target not found...',
            '> 404 Exception...',
            '> Resource unavailable.'
        ],
        currentLog: 0,
        init() {
            setInterval(() => {
                this.currentLog = (this.currentLog + 1) % this.logs.length;
            }, 2000);
        }
    }" class="min-h-screen w-full flex justify-center items-center relative overflow-hidden bg-black">
        <!-- Tech Background Grid -->
        <div class="absolute inset-0 opacity-30 -z-10">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(220,38,38,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(220,38,38,0.03)_1px,transparent_1px)] bg-[length:30px_30px] animate-[gridMove_20s_linear_infinite]" style="transform: perspective(500px) rotateX(60deg) translateY(-100px) translateZ(-200px); width: 200%; height: 200%;"></div>
        </div>
        
        <!-- Particles -->
        <div class="absolute inset-0 pointer-events-none -z-10">
            <div class="absolute top-1/5 left-1/5 w-1 h-1 bg-red-600 rounded-full opacity-20 animate-[float_10s_infinite]"></div>
            <div class="absolute top-4/5 left-4/5 w-1.5 h-1.5 bg-red-600 rounded-full opacity-20 animate-[float_10s_infinite] [animation-delay:-2s]"></div>
            <div class="absolute top-2/5 left-3/5 w-[3px] h-[3px] bg-red-600 rounded-full opacity-20 animate-[float_10s_infinite] [animation-delay:-5s]"></div>
        </div>

        <div class="text-center px-4 max-w-2xl relative z-10">
            <!-- Error Code -->
            <div class="mb-8 relative">
                <h1 class="text-[12rem] font-black text-red-600 leading-none animate-pulse" style="text-shadow: 0 0 30px rgba(220,38,38,0.6), 0 0 60px rgba(220,38,38,0.4);">404</h1>
                <div class="absolute inset-0 text-[12rem] font-black text-rose-400 opacity-20 blur-sm leading-none">404</div>
            </div>
            
            <h2 class="text-4xl font-bold text-white mb-4 tracking-[0.3em] uppercase" style="text-shadow: 0 0 15px rgba(220,38,38,0.5);">PÁGINA NO ENCONTRADA</h2>
            <div class="w-32 h-0.5 bg-gradient-to-r from-transparent via-red-600 to-transparent mx-auto mb-6 shadow-[0_0_10px_rgba(220,38,38,0.6)]"></div>
            
            <p class="text-neutral-400 text-lg mb-8 leading-relaxed">
                Parece que te has perdido en el ciberespacio.<br>
                La página que buscas no existe o ha sido movida.
            </p>
            
            <div class="flex justify-center">
                <a href="{{ url('/') }}" class="group relative px-8 py-4 bg-red-600 text-white font-semibold uppercase tracking-wider border border-red-600 overflow-hidden transition-all duration-300 hover:shadow-[0_0_20px_rgba(220,38,38,0.6)]">
                    <span class="relative z-10">VOLVER AL SISTEMA</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-rose-500 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
            </div>

            <!-- System Log Alpine -->
            <div class="mt-8 p-4 bg-black/40 border border-red-600/30 rounded-lg font-mono text-xs text-red-400">
                <span x-text="logs[currentLog]" class="transition-opacity duration-200"></span><span class="animate-pulse">_</span>
            </div>
        </div>
    </div>
</x-guest-layout>
