<x-app-layout>
    <x-slot:header>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-tr from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-shield text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Detalles del Rol</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $role->nombre }}</p>
            </div>
        </div>
        <div class="ml-auto flex items-center gap-3">
            @if($role->es_sistema)
                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-sm font-medium rounded-lg">
                    <i class="fas fa-server"></i>
                    Rol de Sistema
                </span>
            @endif
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a Lista</span>
            </a>
        </div>
    </x-slot:header>

    <div class="space-y-6">
        <!-- Card 1: Información General -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Información General</h3>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">Nombre del Rol</label>
                        <div class="text-base font-semibold text-slate-900 dark:text-white">{{ $role->nombre }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">Usuarios Asignados</label>
                        <div class="text-base font-semibold text-slate-900 dark:text-white">{{ $role->usuarios->count() }} Usuarios</div>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">Descripción</label>
                    <div class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
                        {{ $role->descripcion ?? 'Sin descripción definida.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Permisos Concedidos -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <i class="fas fa-key text-blue-500 text-lg"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Permisos Concedidos</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">Accesos habilitados para este perfil</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @php
                    $permissions = $role->permisos;
                    $groupedPermissions = $permissions->groupBy('modulo');
                @endphp

                @forelse($groupedPermissions as $modulo => $moduloPermissions)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        <div class="border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden">
                            <div class="px-4 py-3 bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                                <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ ucfirst($modulo) }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $moduloPermissions->count() }} Permisos</span>
                            </div>
                            <div class="p-4 space-y-2">
                                @foreach($moduloPermissions as $permiso)
                                    <div class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                                        <i class="fas fa-check text-green-500 text-xs"></i>
                                        {{ $permiso->nombre }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i class="fas fa-lock text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                        <p class="text-slate-600 dark:text-slate-400">Este rol no tiene permisos asignados.</p>
                    </div>
                @endforelse
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700">
                <a href="{{ route('admin.roles.edit', $role->id) }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-amber-600 to-amber-500 text-white text-sm font-medium rounded-lg hover:from-amber-700 hover:to-amber-600 transition-all shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50">
                    <i class="fas fa-edit"></i>
                    <span>Editar Rol</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
