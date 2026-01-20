<x-app-layout>
    <x-slot:header>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-tr from-rose-500 to-purple-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Gestión de Usuarios</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">Administra los accesos, roles y perfiles del sistema</p>
            </div>
        </div>
    </x-slot:header>

    <div x-data="{
        search: '{{ request('search') }}',
        role: '{{ request('rol') }}',
        perPage: {{ request('per_page', 10) }},
        showFilters: false,
        deleteUser(id, name) {
            if (confirm(`¿Eliminar usuario ${name}?`)) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    }" class="space-y-6">
        
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-600 dark:text-green-400 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        {{-- Control Panel --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 space-y-6">
            
            {{-- Header Actions --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input 
                            type="text" 
                            x-model="search"
                            @input.debounce.500ms="window.location.href = '{{ route('admin.usuarios.index') }}?search=' + search + '&rol=' + role + '&per_page=' + perPage"
                            placeholder="Buscar por nombre o correo..."
                            class="w-full pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent">
                    </div>
                </div>
                <a href="{{ route('admin.usuarios.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-rose-600 to-rose-500 hover:from-rose-700 hover:to-rose-600 text-white font-medium rounded-lg shadow-sm transition-all">
                    <i class="fas fa-plus"></i>
                    <span>Nuevo Usuario</span>
                </a>
            </div>

            {{-- Filters Row --}}
            <div class="flex flex-wrap items-center gap-3">
                {{-- Role Filter --}}
                <div class="relative">
                    <i class="fas fa-user-tag absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    <select 
                        x-model="role"
                        @change="window.location.href = '{{ route('admin.usuarios.index') }}?search=' + search + '&rol=' + role + '&per_page=' + perPage"
                        class="pl-10 pr-8 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-rose-500 appearance-none cursor-pointer">
                        <option value="">Todos los Roles</option>
                        <option value="admin">Administrador</option>
                        <option value="user">Usuario</option>
                        <option value="collaborator">Colaborador</option>
                        <option value="guest">Invitado</option>
                    </select>
                </div>

                {{-- Per Page --}}
                <div class="relative">
                    <i class="fas fa-list-ol absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    <select 
                        x-model="perPage"
                        @change="window.location.href = '{{ route('admin.usuarios.index') }}?search=' + search + '&rol=' + role + '&per_page=' + perPage"
                        class="pl-10 pr-8 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-rose-500 appearance-none cursor-pointer">
                        <option value="10">10 por pág.</option>
                        <option value="25">25 por pág.</option>
                        <option value="50">50 por pág.</option>
                    </select>
                </div>

                {{-- Export Button --}}
                <button 
                    type="button"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg transition-colors">
                    <i class="fas fa-file-export"></i>
                    <span>Exportar</span>
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Prompts</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Último Acceso</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($usuarios as $usuario)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <x-user-avatar :user="$usuario" size="md" />
                                        <div>
                                            <div class="text-sm font-medium text-slate-900 dark:text-white">{{ $usuario->name ?? 'N/A' }}</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">{{ $usuario->email ?? 'Sin email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $roleBadgeClasses = [
                                            'admin' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
                                            'user' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                                            'collaborator' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                                            'guest' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                                        ];
                                        $roleLabels = [
                                            'admin' => 'Administrador',
                                            'user' => 'Usuario',
                                            'collaborator' => 'Colaborador',
                                            'guest' => 'Invitado',
                                        ];
                                        $roleName = $usuario->role?->nombre ?? 'guest';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleBadgeClasses[$roleName] ?? $roleBadgeClasses['guest'] }}">
                                        {{ $roleLabels[$roleName] ?? 'Sin rol' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $usuario->cuenta_activa ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }}">
                                        {{ $usuario->cuenta_activa ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $usuario->prompts_count ?? 0 }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">
                                        {{ $usuario->ultimo_acceso ? \Carbon\Carbon::parse($usuario->ultimo_acceso)->diffForHumans() : 'Nunca' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.usuarios.show', $usuario->id) }}" 
                                           class="p-2 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg transition-colors" 
                                           title="Ver Detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" 
                                           class="p-2 text-amber-600 hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-900/30 rounded-lg transition-colors" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button 
                                            type="button"
                                            @click="deleteUser({{ $usuario->id }}, '{{ $usuario->name }}')"
                                            class="p-2 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/30 rounded-lg transition-colors" 
                                            title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <form id="delete-form-{{ $usuario->id }}" action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400">
                                        <i class="fas fa-users text-5xl opacity-30"></i>
                                        <p class="text-sm">No se encontraron usuarios registrados</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($usuarios->hasPages())
            <div class="flex justify-center">
                {{ $usuarios->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-app-layout>