<x-app-layout :title="$evento->titulo . ' - PromptVault'">
    <div class="max-w-4xl mx-auto px-6 py-8">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                    <i class="fas fa-calendar-day text-rose-600"></i>
                    {{ $evento->titulo }}
                </h1>
                <p class="text-slate-600 dark:text-slate-400 mt-2">
                    <i class="fas fa-clock mr-2"></i>
                    {{ $evento->fecha_inicio->format('d/m/Y H:i') }}
                    @if($evento->fecha_fin)
                        - {{ $evento->fecha_fin->format('d/m/Y H:i') }}
                    @endif
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('calendario.edit', $evento) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-6 py-3 rounded-lg transition-colors flex items-center gap-2">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('calendario.index') }}" 
                   class="bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-medium px-6 py-3 rounded-lg border border-slate-200 dark:border-slate-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        {{-- Contenido --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg overflow-hidden">
            
            {{-- Tipo badge --}}
            <div class="bg-gradient-to-r from-rose-500 to-pink-600 px-6 py-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                    <i class="fas fa-tag mr-2"></i>
                    {{ ucfirst($evento->tipo->value) }}
                </span>
            </div>

            <div class="p-8 space-y-6">
                
                {{-- Descripción --}}
                @if($evento->descripcion)
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Descripción</h3>
                    <p class="text-slate-600 dark:text-slate-400">{{ $evento->descripcion }}</p>
                </div>
                @endif

                {{-- Detalles en grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Fecha inicio --}}
                    <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-100 dark:bg-green-900/20 p-3 rounded-lg">
                                <i class="fas fa-play text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Inicio</p>
                                <p class="font-bold text-slate-900 dark:text-white">
                                    {{ $evento->fecha_inicio->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Fecha fin --}}
                    @if($evento->fecha_fin)
                    <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-red-100 dark:bg-red-900/20 p-3 rounded-lg">
                                <i class="fas fa-stop text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Fin</p>
                                <p class="font-bold text-slate-900 dark:text-white">
                                    {{ $evento->fecha_fin->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Ubicación --}}
                    @if($evento->ubicacion)
                    <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-100 dark:bg-blue-900/20 p-3 rounded-lg">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Ubicación</p>
                                <p class="font-bold text-slate-900 dark:text-white">{{ $evento->ubicacion }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Duración --}}
                    @if($evento->fecha_fin)
                    <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-amber-100 dark:bg-amber-900/20 p-3 rounded-lg">
                                <i class="fas fa-hourglass-half text-amber-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Duración</p>
                                <p class="font-bold text-slate-900 dark:text-white">
                                    {{ $evento->fecha_inicio->diffForHumans($evento->fecha_fin, true) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Metadata --}}
                <div class="pt-6 border-t border-slate-200 dark:border-slate-700">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Creado el {{ $evento->created_at->format('d/m/Y H:i') }}
                        @if($evento->updated_at != $evento->created_at)
                            • Actualizado el {{ $evento->updated_at->format('d/m/Y H:i') }}
                        @endif
                    </p>
                </div>

                {{-- Acciones --}}
                <div class="flex gap-3 pt-6">
                    <a href="{{ route('calendario.edit', $evento) }}" 
                       class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 rounded-lg transition-colors text-center">
                        <i class="fas fa-edit mr-2"></i> Editar Evento
                    </a>
                    <button 
                        onclick="if(confirm('¿Estás seguro de eliminar este evento?')) document.getElementById('deleteForm').submit()"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white font-medium py-3 rounded-lg transition-colors">
                        <i class="fas fa-trash mr-2"></i> Eliminar Evento
                    </button>
                </div>
            </div>
        </div>

        {{-- Delete Form --}}
        <form id="deleteForm" action="{{ route('calendario.destroy', $evento) }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</x-app-layout>
