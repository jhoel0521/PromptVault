@extends('components.usuario')

@section('title', $prompt->titulo . ' - PromptVault')

@section('content')
<div class="min-h-screen bg-bgDark text-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-8">
        
        {{-- Botón Volver --}}
        <a href="{{ route('prompts.index') }}" class="inline-flex items-center text-gray-400 hover:text-white mb-6 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Volver a la biblioteca
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Columna Izquierda: Contenido --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Título y Favorito --}}
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">{{ $prompt->titulo }}</h1>
                        @if($prompt->descripcion)
                            <p class="text-gray-400">{{ $prompt->descripcion }}</p>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <button 
                            class="bg-cardDark border border-gray-700 text-gray-300 hover:text-primary px-4 py-2 rounded-lg transition-colors"
                            onclick="toggleFavorite()"
                        >
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>

                {{-- Caja del Prompt --}}
                <div class="bg-cardDark border border-gray-700 rounded-xl overflow-hidden">
                    <div class="bg-gray-800 px-6 py-4 flex justify-between items-center border-b border-gray-700">
                        <span class="text-xs font-mono text-gray-400 uppercase tracking-wider">PROMPT</span>
                        <button 
                            class="text-xs text-primary hover:text-white transition-colors flex items-center gap-2"
                            onclick="copyPrompt()"
                        >
                            <i class="fas fa-copy"></i> Copiar
                        </button>
                    </div>
                    <div class="p-6 bg-[#15171e]">
                        <pre id="promptContent" class="font-mono text-sm text-gray-300 whitespace-pre-wrap">{{ $prompt->contenido }}</pre>
                    </div>
                </div>

                {{-- Comentarios --}}
                @if($prompt->comentarios->count())
                    <div>
                        <h3 class="text-lg font-bold text-white mb-4">Comentarios</h3>
                        <div class="space-y-4">
                            @foreach($prompt->comentarios as $comentario)
                                <div class="bg-cardDark p-4 rounded-xl border border-gray-800 flex gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-purple-600 to-blue-500 flex-shrink-0 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($comentario->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $comentario->user->name }}</p>
                                        <p class="text-sm text-gray-400">{{ $comentario->contenido }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Columna Derecha: Detalles y Acciones --}}
            <div class="space-y-6">
                
                {{-- Panel de Acciones (CRUD) --}}
                <div class="bg-cardDark border border-gray-800 rounded-xl p-6 shadow-lg">
                    <h3 class="text-xs font-bold text-gray-500 uppercase mb-4 tracking-wider">Administrar</h3>

                    @can('update', $prompt)
                        <a 
                            href="{{ route('prompts.edit', $prompt) }}"
                            class="flex items-center justify-center w-full bg-blue-600/10 hover:bg-blue-600/20 text-blue-500 border border-blue-600/30 py-2 rounded-lg mb-3 transition-colors"
                        >
                            <i class="fas fa-pen mr-2"></i> Editar
                        </a>
                    @endcan

                    @can('delete', $prompt)
                        <button
                            onclick="confirmDelete()"
                            class="flex items-center justify-center w-full bg-red-600/10 hover:bg-red-600/20 text-red-500 border border-red-600/30 py-2 rounded-lg transition-colors"
                        >
                            <i class="fas fa-trash mr-2"></i> Eliminar
                        </button>
                    @endcan
                </div>

                {{-- Metadatos --}}
                <div class="bg-cardDark border border-gray-800 rounded-xl p-6">
                    <h3 class="text-sm font-bold text-white mb-4">Información</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Visibilidad</span>
                            <span class="text-white bg-gray-700 px-3 py-1 rounded-full capitalize">
                                {{ $prompt->visibilidad }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Vistas</span>
                            <span class="text-white"><i class="fas fa-eye mr-1"></i> {{ $prompt->conteo_vistas ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Versión Actual</span>
                            <span class="text-white">v{{ $prompt->version_actual }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Creado</span>
                            <span class="text-white">{{ $prompt->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    {{-- Etiquetas --}}
                    @if($prompt->etiquetas->count())
                        <div class="mt-4 pt-4 border-t border-gray-700">
                            <h6 class="text-xs font-bold text-gray-500 uppercase mb-3">Etiquetas</h6>
                            <div class="flex flex-wrap gap-2">
                                @foreach($prompt->etiquetas as $etiqueta)
                                    <span 
                                        class="text-xs px-3 py-1 rounded-full text-white"
                                        style="background-color: {{ $etiqueta->color_hex ?? '#6c757d' }}40; color: {{ $etiqueta->color_hex ?? '#6c757d' }}"
                                    >
                                        {{ $etiqueta->nombre }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Compartir Card --}}
                @can('share', $prompt)
                    <div class="bg-cardDark border border-gray-800 rounded-xl p-6">
                        <h3 class="text-sm font-bold text-white mb-4">Compartir Acceso</h3>
                        
                        <form action="{{ route('prompts.compartir', $prompt) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="block text-gray-400 text-xs font-bold mb-2">Email del usuario</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    class="w-full bg-bgDark border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary transition-colors text-sm"
                                    placeholder="ejemplo@correo.com"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="nivel_acceso" class="block text-gray-400 text-xs font-bold mb-2">Nivel de Acceso</label>
                                <select 
                                    name="nivel_acceso" 
                                    id="nivel_acceso" 
                                    class="w-full bg-bgDark border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary transition-colors text-sm"
                                >
                                    <option value="lectura">Solo Lectura</option>
                                    <option value="edicion">Edición</option>
                                </select>
                            </div>
                            <button 
                                type="submit" 
                                class="w-full bg-primary hover:bg-rose-600 text-white font-bold py-2 rounded-lg transition-colors text-sm"
                            >
                                Compartir
                            </button>
                        </form>

                        {{-- Usuarios con acceso --}}
                        @if($prompt->accesosCompartidos->count())
                            <div class="pt-4 border-t border-gray-700">
                                <h6 class="text-xs font-bold text-gray-500 uppercase mb-3">Usuarios con acceso</h6>
                                <div class="space-y-2">
                                    @foreach($prompt->accesosCompartidos as $acceso)
                                        <div class="flex justify-between items-center bg-bgDark rounded-lg p-2">
                                            <div>
                                                <span class="block text-sm text-white">{{ $acceso->user->name }}</span>
                                                <small class="text-xs text-gray-500">{{ $acceso->nivel_acceso }}</small>
                                            </div>
                                            <form action="{{ route('prompts.quitarAcceso', [$prompt, $acceso->user]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="text-red-500 hover:text-red-400 transition-colors text-sm"
                                                    title="Quitar acceso"
                                                >
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endcan
            </div>
        </div>

        {{-- Historial de Versiones --}}
        <div class="mt-8 bg-cardDark border border-gray-800 rounded-xl overflow-hidden">
            <div class="bg-gray-800 px-6 py-4 border-b border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">Historial de Versiones</h3>
                <a href="{{ route('prompts.historial', $prompt) }}" class="text-primary hover:text-white text-sm transition-colors">Ver Todo</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900 border-b border-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">Versión</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">Cambio</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prompt->versiones->take(5) as $version)
                            <tr class="border-b border-gray-700 hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-3 text-sm text-white">v{{ $version->numero_version }}</td>
                                <td class="px-6 py-3 text-sm text-gray-400">{{ $version->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-3 text-sm text-gray-400">{{ Str::limit($version->mensaje_cambio, 30) }}</td>
                                <td class="px-6 py-3 text-sm">
                                    @if($version->numero_version != $prompt->version_actual)
                                        <form action="{{ route('prompts.restaurar', [$prompt, $version]) }}" method="POST" class="inline">
                                            @csrf
                                            <button 
                                                type="submit" 
                                                class="text-yellow-500 hover:text-yellow-400 transition-colors"
                                                title="Restaurar esta versión"
                                            >
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="bg-green-600 text-white text-xs px-2 py-1 rounded">Actual</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Delete Form (Hidden) --}}
    <form id="deleteForm" action="{{ route('prompts.destroy', $prompt) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<script>
    function copyPrompt() {
        const text = document.getElementById('promptContent').innerText;
        navigator.clipboard.writeText(text).then(() => {
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Copiado';
            btn.classList.add('!text-green-500');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('!text-green-500');
            }, 2000);
        }).catch(() => {
            alert('Error al copiar');
        });
    }

    function toggleFavorite() {
        const btn = event.target.closest('button');
        btn.classList.toggle('text-primary');
        btn.classList.toggle('text-gray-300');
    }

    function confirmDelete() {
        if (confirm('¿Seguro que deseas eliminar este prompt? Esta acción no se puede deshacer.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endsection
