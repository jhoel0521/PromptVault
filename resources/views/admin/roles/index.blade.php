<x-app-layout>
    <x-slot:header>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-tr from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-tag text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Roles</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">Gestión de roles y perfiles de acceso al sistema</p>
            </div>
        </div>
        <div class="ml-auto">
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-rose-600 to-rose-500 text-white rounded-lg hover:from-rose-700 hover:to-rose-600 transition-all shadow-lg shadow-rose-500/30 hover:shadow-rose-500/50">
                <i class="fas fa-plus"></i>
                <span>Nuevo Rol</span>
            </a>
        </div>
    </x-slot:header>

    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden"
         x-data="{
             search: '{{ request('search') }}',
             tipo: '{{ request('tipo') }}',
             perPage: '{{ request('per_page', 10) }}',
             applyFilters() {
                 let url = new URL(window.location.href);
                 if (this.search) url.searchParams.set('search', this.search);
                 else url.searchParams.delete('search');
                 if (this.tipo) url.searchParams.set('tipo', this.tipo);
                 else url.searchParams.delete('tipo');
                 url.searchParams.set('per_page', this.perPage);
                 window.location.href = url.toString();
             },
             deleteRole(roleId) {
                 if (confirm('¿Está seguro que desea eliminar este rol? Esta acción no se puede deshacer.')) {
                     document.getElementById('delete-form-' + roleId).submit();
                 }
             }
         }">

        <!-- Filtros -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-700 space-y-4">
            <!-- Búsqueda -->
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" 
                           x-model.debounce.500ms="search"
                           @input="applyFilters()"
                           placeholder="Buscar por nombre o descripción..."
                           class="w-full pl-11 pr-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-white dark:bg-slate-800 text-slate-900 dark:text-white">
                </div>
            </div>

            <!-- Filtros -->
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <select x-model="tipo"
                            @change="applyFilters()"
                            class="w-full pl-11 pr-10 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-white dark:bg-slate-800 text-slate-900 dark:text-white appearance-none cursor-pointer">
                        <option value="">Todos los Tipos</option>
                        <option value="sistema">Sistema</option>
                        <option value="personalizado">Personalizado</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>

                <div class="relative w-full sm:w-48">
                    <i class="fas fa-list-ol absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <select x-model="perPage"
                            @change="applyFilters()"
                            class="w-full pl-11 pr-10 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-white dark:bg-slate-800 text-slate-900 dark:text-white appearance-none cursor-pointer">
                        <option value="10">10 por pág.</option>
                        <option value="25">25 por pág.</option>
                        <option value="50">50 por pág.</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>

                <a href="#" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                    <i class="fas fa-file-export"></i>
                    <span class="hidden sm:inline">Exportar</span>
                </a>
            </div>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Rol</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Usuarios</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($roles as $rol)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $rol->nombre }}</span>
                                    <span class="text-xs text-slate-600 dark:text-slate-400 mt-1">{{ Str::limit($rol->descripcion, 50) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($rol->es_sistema)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                        <i class="fas fa-shield-alt"></i>
                                        Sistema
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                        <i class="fas fa-edit"></i>
                                        Personalizado
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($rol->activo)
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $rol->usuarios_count }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.roles.show', $rol->id) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors"
                                       title="Ver Detalles">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    
                                    @if(!$rol->es_sistema)
                                        <a href="{{ route('admin.roles.edit', $rol->id) }}" 
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-colors"
                                           title="Editar">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button type="button"
                                                @click="deleteRole({{ $rol->id }})"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors"
                                                title="Eliminar">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                        <form id="delete-form-{{ $rol->id }}" action="{{ route('admin.roles.destroy', $rol->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @else
                                        <button type="button"
                                                disabled
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-600 cursor-not-allowed"
                                                title="No editable (Sistema)">
                                            <i class="fas fa-lock text-sm"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fas fa-user-tag text-4xl text-slate-300 dark:text-slate-600"></i>
                                    <p class="text-slate-600 dark:text-slate-400">No se encontraron roles registrados</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($roles->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                {{ $roles->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
