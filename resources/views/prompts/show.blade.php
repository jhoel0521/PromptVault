@extends('components.usuario')

@section('title', $prompt->titulo . ' - PromptVault')

@section('content')
<div class="min-h-screen text-[var(--text-dark)]">
    <div class="max-w-7xl mx-auto px-6 py-8">
        
        {{-- Botón Volver --}}
        <a href="{{ route('prompts.index') }}" class="inline-flex items-center text-[var(--text-muted)] hover:text-[var(--text-dark)] mb-6 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Volver a la biblioteca
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Columna Izquierda: Contenido --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Título y Favorito --}}
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-4xl font-bold text-[var(--text-dark)] mb-2">{{ $prompt->titulo }}</h1>
                        @if($prompt->descripcion)
                            <p class="text-[var(--text-muted)]">{{ $prompt->descripcion }}</p>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <button 
                            class="bg-[var(--light-bg)] border border-[var(--border-color)] text-[var(--text-muted)] hover:text-[var(--primary-red)] px-4 py-2 rounded-lg transition-colors"
                            onclick="toggleFavorite()"
                        >
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>

                {{-- Caja del Prompt --}}
                <div class="bg-[var(--light-bg)] border border-[var(--border-color)] rounded-xl overflow-hidden">
                    <div class="bg-[var(--bg-surface-secondary)] px-6 py-4 flex justify-between items-center border-b border-[var(--border-color)]">
                        <span class="text-xs font-mono text-[var(--text-muted)] uppercase tracking-wider">PROMPT</span>
                        <button 
                            class="text-xs text-[var(--primary-red)] hover:text-[var(--primary-red-hover)] transition-colors flex items-center gap-2"
                            onclick="copyPrompt()"
                        >
                            <i class="fas fa-copy"></i> Copiar
                        </button>
                    </div>
                    <div class="p-6 bg-[var(--bg-surface-secondary)]">
                        <pre id="promptContent" class="font-mono text-sm text-[var(--text-dark)] whitespace-pre-wrap">{{ $prompt->contenido }}</pre>
                    </div>
                </div>

                {{-- Comentarios --}}
                @if($prompt->comentarios->count())
                    <div>
                        <h3 class="text-lg font-bold text-white mb-4">Comentarios</h3>
                        <div class="space-y-4">
                            @foreach($prompt->comentarios as $comentario)
                                <div class="bg-[var(--light-bg)] p-4 rounded-xl border border-[var(--border-color)] flex gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-purple-600 to-blue-500 flex-shrink-0 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($comentario->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-[var(--text-dark)]">{{ $comentario->user->name }}</p>
                                        <p class="text-sm text-[var(--text-muted)]">{{ $comentario->contenido }}</p>
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
                <div class="bg-[var(--light-bg)] border border-[var(--border-color)] rounded-xl p-6 shadow-lg">
                    <h3 class="text-xs font-bold text-[var(--text-muted)] uppercase mb-4 tracking-wider">Administrar</h3>

                    @can('update', $prompt)
                        <a 
                            href="{{ route('prompts.edit', $prompt) }}"
                            class="flex items-center justify-center w-full bg-[rgba(59,130,246,0.12)] hover:bg-[rgba(59,130,246,0.2)] text-blue-500 border border-[rgba(59,130,246,0.3)] py-2 rounded-lg mb-3 transition-colors"
                        >
                            <i class="fas fa-pen mr-2"></i> Editar
                        </a>
                    @endcan

                    @can('delete', $prompt)
                        <button
                            onclick="confirmDelete()"
                            class="flex items-center justify-center w-full bg-[rgba(239,68,68,0.12)] hover:bg-[rgba(239,68,68,0.2)] text-red-500 border border-[rgba(239,68,68,0.3)] py-2 rounded-lg transition-colors"
                        >
                            <i class="fas fa-trash mr-2"></i> Eliminar
                        </button>
                    @endcan
                </div>

                {{-- Metadatos --}}
                <div class="bg-[var(--light-bg)] border border-[var(--border-color)] rounded-xl p-6">
                    <h3 class="text-sm font-bold text-[var(--text-dark)] mb-4">Información</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-[var(--text-muted)]">Visibilidad</span>
                            <span class="text-[var(--text-dark)] bg-[var(--bg-surface-secondary)] px-3 py-1 rounded-full capitalize">
                                {{ $prompt->visibilidad }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[var(--text-muted)]">Vistas</span>
                            <span class="text-[var(--text-dark)]"><i class="fas fa-eye mr-1"></i> {{ $prompt->conteo_vistas ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[var(--text-muted)]">Versión Actual</span>
                            <span class="text-[var(--text-dark)]">v{{ $prompt->version_actual }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[var(--text-muted)]">Creado</span>
                            <span class="text-[var(--text-dark)]">{{ $prompt->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    {{-- Etiquetas --}}
                    @if($prompt->etiquetas->count())
                        <div class="mt-4 pt-4 border-t border-[var(--border-color)]">
                            <h6 class="text-xs font-bold text-[var(--text-muted)] uppercase mb-3">Etiquetas</h6>
                            <div class="flex flex-wrap gap-2">
                                @foreach($prompt->etiquetas as $etiqueta)
                                    <span 
                                        class="text-xs px-3 py-1 rounded-full text-[var(--text-dark)]"
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
                    <div class="bg-[var(--light-bg)] border border-[var(--border-color)] rounded-xl p-6">
                        <h3 class="text-sm font-bold text-[var(--text-dark)] mb-4">Compartir Acceso</h3>
                        
                        <form action="{{ route('prompts.compartir', $prompt) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="block text-[var(--text-muted)] text-xs font-bold mb-2">Email del usuario</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    class="w-full bg-[var(--input-bg)] border border-[var(--border-color)] rounded-lg px-4 py-2 text-[var(--text-dark)] focus:outline-none focus:border-[var(--primary-red)] transition-colors text-sm"
                                    placeholder="ejemplo@correo.com"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="nivel_acceso" class="block text-[var(--text-muted)] text-xs font-bold mb-2">Nivel de Acceso</label>
                                <select 
                                    name="nivel_acceso" 
                                    id="nivel_acceso" 
                                    class="w-full bg-[var(--input-bg)] border border-[var(--border-color)] rounded-lg px-4 py-2 text-[var(--text-dark)] focus:outline-none focus:border-[var(--primary-red)] transition-colors text-sm"
                                >
                                    <option value="lectura">Solo Lectura</option>
                                    <option value="edicion">Edición</option>
                                </select>
                            </div>
                            <button 
                                type="submit" 
                                class="w-full bg-[var(--primary-red)] hover:bg-[var(--primary-red-hover)] text-white font-bold py-2 rounded-lg transition-colors text-sm"
                            >
                                Compartir
                            </button>
                        </form>

                        {{-- Usuarios con acceso --}}
                        @if($prompt->accesosCompartidos->count())
                            <div class="pt-4 border-t border-[var(--border-color)]">
                                <h6 class="text-xs font-bold text-[var(--text-muted)] uppercase mb-3">Usuarios con acceso</h6>
                                <div class="space-y-2">
                                    @foreach($prompt->accesosCompartidos as $acceso)
                                        <div class="flex justify-between items-center bg-[var(--bg-surface-secondary)] rounded-lg p-2">
                                            <div>
                                                <span class="block text-sm text-[var(--text-dark)]">{{ $acceso->user->name }}</span>
                                                <small class="text-xs text-[var(--text-muted)]">{{ $acceso->nivel_acceso }}</small>
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
        <div class="mt-8 bg-[var(--light-bg)] border border-[var(--border-color)] rounded-xl overflow-hidden">
            <div class="bg-[var(--bg-surface-secondary)] px-6 py-4 border-b border-[var(--border-color)] flex justify-between items-center">
                <h3 class="text-lg font-bold text-[var(--text-dark)]">Historial de Versiones</h3>
                <a href="{{ route('prompts.historial', $prompt) }}" class="text-[var(--primary-red)] hover:text-[var(--primary-red-hover)] text-sm transition-colors">Ver Todo</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[var(--bg-surface-secondary)] border-b border-[var(--border-color)]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-[var(--text-muted)] uppercase">Versión</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-[var(--text-muted)] uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-[var(--text-muted)] uppercase">Cambio</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-[var(--text-muted)] uppercase">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prompt->versiones->take(5) as $version)
                            <tr class="border-b border-[var(--border-color)] hover:bg-[var(--bg-surface-secondary)] transition-colors">
                                <td class="px-6 py-3 text-sm text-[var(--text-dark)]">v{{ $version->numero_version }}</td>
                                <td class="px-6 py-3 text-sm text-[var(--text-muted)]">{{ $version->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-3 text-sm text-[var(--text-muted)]">{{ Str::limit($version->mensaje_cambio, 30) }}</td>
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
