<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mis Prompts
            </h2>
            <a href="{{ route('prompts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                Crear Nuevo Prompt
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtros y búsqueda -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('prompts.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                            <input type="text" name="buscar" value="{{ request('buscar') }}" 
                                   placeholder="Título, contenido, descripción..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                            <select name="categoria_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">IA Destino</label>
                            <input type="text" name="ia_destino" value="{{ request('ia_destino') }}" 
                                   placeholder="ChatGPT, Claude, etc."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ordenar por</label>
                            <select name="orden" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="reciente" {{ request('orden') == 'reciente' ? 'selected' : '' }}>Más reciente</option>
                                <option value="titulo" {{ request('orden') == 'titulo' ? 'selected' : '' }}>Título A-Z</option>
                                <option value="uso" {{ request('orden') == 'uso' ? 'selected' : '' }}>Más usado</option>
                                <option value="modificacion" {{ request('orden') == 'modificacion' ? 'selected' : '' }}>Última modificación</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                            Aplicar Filtros
                        </button>
                        <a href="{{ route('prompts.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                            Limpiar
                        </a>
                        <label class="flex items-center ml-4">
                            <input type="checkbox" name="favoritos" value="1" {{ request('favoritos') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            <span class="ml-2 text-sm text-gray-700">Solo favoritos</span>
                        </label>
                    </div>
                </form>
            </div>

            <!-- Lista de Prompts -->
            @if($prompts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($prompts as $prompt)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-semibold text-gray-900 flex-1">
                                    {{ $prompt->titulo }}
                                </h3>
                                <form action="{{ route('prompts.favorito', $prompt) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-500 hover:text-yellow-600 transition">
                                        <svg class="w-6 h-6 {{ $prompt->es_favorito ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            @if($prompt->descripcion)
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($prompt->descripcion, 100) }}</p>
                            @endif

                            <div class="flex flex-wrap gap-2 mb-3">
                                @if($prompt->categoria)
                                    <span class="px-2 py-1 text-xs font-medium rounded" 
                                          style="background-color: {{ $prompt->categoria->color }}20; color: {{ $prompt->categoria->color }}">
                                        {{ $prompt->categoria->nombre }}
                                    </span>
                                @endif

                                @if($prompt->ia_destino)
                                    <span class="px-2 py-1 text-xs font-medium rounded bg-purple-100 text-purple-800">
                                        {{ $prompt->ia_destino }}
                                    </span>
                                @endif

                                @foreach($prompt->etiquetas->take(3) as $etiqueta)
                                    <span class="px-2 py-1 text-xs font-medium rounded bg-gray-100 text-gray-700">
                                        {{ $etiqueta->nombre }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="text-xs text-gray-500 mb-4">
                                <span>Versión {{ $prompt->version_actual }}</span> •
                                <span>Usado {{ $prompt->veces_usado }} veces</span>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('prompts.show', $prompt) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center px-4 py-2 rounded-lg transition text-sm">
                                    Ver Detalles
                                </a>
                                <a href="{{ route('prompts.edit', $prompt) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition text-sm">
                                    Editar
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $prompts->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay prompts todavía</h3>
                    <p class="text-gray-600 mb-6">Comienza creando tu primer prompt para gestionar tus instrucciones de IA</p>
                    <a href="{{ route('prompts.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                        Crear Mi Primer Prompt
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
