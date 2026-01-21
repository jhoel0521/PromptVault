<x-app-layout :title="$prompt->titulo . ' - PromptVault'">
    <div class="max-w-7xl mx-auto px-6 py-8">
        
        {{-- Botón Volver --}}
        <a href="{{ route('prompts.index') }}" class="inline-flex items-center text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white mb-6 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Volver a la biblioteca
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Columna Izquierda: Contenido --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Título y Favorito --}}
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-2">{{ $prompt->titulo }}</h1>
                        @if($prompt->descripcion)
                            <p class="text-slate-600 dark:text-slate-400">{{ $prompt->descripcion }}</p>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <button 
                            class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:text-rose-600 dark:hover:text-rose-500 px-4 py-2 rounded-lg transition-colors"
                            onclick="toggleFavorite()"
                        >
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>

                {{-- Caja del Prompt --}}
                <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden">
                    <div class="bg-slate-50 dark:bg-slate-900 px-6 py-4 flex justify-between items-center border-b border-slate-200 dark:border-slate-700">
                        <span class="text-xs font-mono text-slate-500 dark:text-slate-400 uppercase tracking-wider">PROMPT</span>
                        <button 
                            class="text-xs text-rose-600 hover:text-rose-700 dark:text-rose-500 dark:hover:text-rose-400 transition-colors flex items-center gap-2"
                            onclick="copyPrompt()"
                        >
                            <i class="fas fa-copy"></i> Copiar
                        </button>
                    </div>
                    <div class="p-6 bg-slate-50 dark:bg-slate-900">
                        <pre id="promptContent" class="font-mono text-sm text-slate-900 dark:text-slate-100 whitespace-pre-wrap">{{ $prompt->contenido }}</pre>
                    </div>
                </div>

                {{-- Comentarios --}}
                @if($prompt->comentarios->count())
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Comentarios</h3>
                        <div class="space-y-4">
                            @foreach($prompt->comentarios as $comentario)
                                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 flex gap-3">
                                    <x-user-avatar :user="$comentario->user" size="lg" class="flex-shrink-0" />
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $comentario->user->name }}</p>
                                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ $comentario->contenido }}</p>
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
                <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-6 shadow-lg">
                    <h3 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-4 tracking-wider">Administrar</h3>

                    @can('update', $prompt)
                        <a 
                            href="{{ route('prompts.edit', $prompt) }}"
                            class="flex items-center justify-center w-full bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 text-blue-600 dark:text-blue-400 border border-blue-300 dark:border-blue-700 py-2 rounded-lg mb-3 transition-colors"
                        >
                            <i class="fas fa-pen mr-2"></i> Editar
                        </a>
                    @endcan

                    @can('delete', $prompt)
                        <button
                            onclick="confirmDelete()"
                            class="flex items-center justify-center w-full bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 border border-red-300 dark:border-red-700 py-2 rounded-lg transition-colors"
                        >
                            <i class="fas fa-trash mr-2"></i> Eliminar
                        </button>
                    @endcan
                </div>

                {{-- Metadatos --}}
                <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Información</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-600 dark:text-slate-400">Visibilidad</span>
                            <span class="text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full capitalize">
                                {{ $prompt->visibilidad }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600 dark:text-slate-400">Vistas</span>
                            <span class="text-slate-900 dark:text-white"><i class="fas fa-eye mr-1"></i> {{ $prompt->conteo_vistas ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600 dark:text-slate-400">Versión Actual</span>
                            <span class="text-slate-900 dark:text-white">v{{ $prompt->version_actual }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600 dark:text-slate-400">Creado</span>
                            <span class="text-slate-900 dark:text-white">{{ $prompt->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    {{-- Etiquetas --}}
                    @if($prompt->etiquetas->count())
                        <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                            <h6 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-3">Etiquetas</h6>
                            <div class="flex flex-wrap gap-2">
                                @foreach($prompt->etiquetas as $etiqueta)
                                    <span 
                                        class="text-xs px-3 py-1 rounded-full"
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
                    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Compartir Acceso</h3>
                        
                        <form action="{{ route('prompts.compartir', $prompt) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="block text-slate-600 dark:text-slate-400 text-xs font-bold mb-2">Email del usuario</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors text-sm"
                                    placeholder="ejemplo@correo.com"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="nivel_acceso" class="block text-slate-600 dark:text-slate-400 text-xs font-bold mb-2">Nivel de Acceso</label>
                                <select 
                                    name="nivel_acceso" 
                                    id="nivel_acceso" 
                                    class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2 text-slate-900 dark:text-slate-100 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors text-sm"
                                >
                                    <option value="lector" class="bg-white dark:bg-slate-900">🔍 Lector (Solo ver)</option>
                                    <option value="comentador" class="bg-white dark:bg-slate-900">💬 Comentador (Ver + Comentar)</option>
                                    <option value="editor" class="bg-white dark:bg-slate-900">✏️ Editor (Ver + Editar + Comentar)</option>
                                </select>
                                <small class="text-slate-500 dark:text-slate-400 text-xs mt-1 block">
                                    Elige el nivel de acceso que deseas dar al usuario
                                </small>
                            </div>
                            <button 
                                type="submit" 
                                class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 rounded-lg transition-colors text-sm flex items-center justify-center gap-2"
                            >
                                <i class="fas fa-share-alt"></i> Compartir Acceso
                            </button>
                        </form>

                        {{-- Usuarios con acceso --}}
                        @if($prompt->accesosCompartidos->count())
                            <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                                <h6 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-3 flex items-center gap-2">
                                    <i class="fas fa-users"></i> Usuarios con acceso ({{ $prompt->accesosCompartidos->count() }})
                                </h6>
                                <div class="space-y-3">
                                    @foreach($prompt->accesosCompartidos as $acceso)
                                        <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-3 border border-slate-200 dark:border-slate-700">
                                            <div class="flex justify-between items-start gap-3">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2">
                                                        <i class="fas fa-user-circle text-slate-400"></i>
                                                        <span class="block text-sm font-semibold text-slate-900 dark:text-white">{{ $acceso->user->name }}</span>
                                                    </div>
                                                    <small class="text-xs text-slate-600 dark:text-slate-400 ml-6">
                                                        {{ $acceso->user->email }}
                                                    </small>
                                                    <div class="mt-1 ml-6">
                                                        @php
                                                            $badgeColor = match($acceso->nivel_acceso) {
                                                                'lector' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                                'comentador' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                                                'editor' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                                default => 'bg-slate-100 text-slate-800'
                                                            };
                                                            $icon = match($acceso->nivel_acceso) {
                                                                'lector' => '🔍',
                                                                'comentador' => '💬',
                                                                'editor' => '✏️',
                                                                default => '❓'
                                                            };
                                                        @endphp
                                                        <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold {{ $badgeColor }}">
                                                            {{ $icon }} {{ ucfirst($acceso->nivel_acceso) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <form action="{{ route('prompts.quitarAcceso', [$prompt, $acceso->user]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button 
                                                        type="submit" 
                                                        class="text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 p-2 rounded transition-colors"
                                                        title="Quitar acceso a {{ $acceso->user->name }}"
                                                    >
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                                <p class="text-xs text-slate-500 dark:text-slate-400 text-center py-3">
                                    <i class="fas fa-info-circle mr-1"></i> No hay usuarios con acceso compartido aún
                                </p>
                            </div>
                        @endif
                    </div>
                @endcan
            </div>
        </div>

        {{-- Historial de Versiones --}}
        <div class="mt-8 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden">
            <div class="bg-slate-50 dark:bg-slate-900 px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Historial de Versiones</h3>
                <a href="{{ route('prompts.historial', $prompt) }}" class="text-rose-600 hover:text-rose-700 dark:text-rose-500 dark:hover:text-rose-400 text-sm transition-colors">Ver Todo</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase">Versión</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase">Cambio</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prompt->versiones->take(5) as $version)
                            <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-900 transition-colors">
                                <td class="px-6 py-3 text-sm text-slate-900 dark:text-white">v{{ $version->numero_version }}</td>
                                <td class="px-6 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $version->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-3 text-sm text-slate-600 dark:text-slate-400">{{ Str::limit($version->mensaje_cambio, 30) }}</td>
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
</x-app-layout>
