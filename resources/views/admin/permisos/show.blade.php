<x-app-layout>
    <x-slot:header>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-key text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Detalles del Permiso</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400 font-mono">{{ $permiso->nombre }}</p>
            </div>
        </div>
        <div class="ml-auto">
            <a href="{{ route('admin.permisos.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a Lista</span>
            </a>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Details -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-info-circle text-cyan-500 text-lg"></i>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Información General</h3>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">Nombre Clave</label>
                        <div class="text-sm font-mono font-semibold text-slate-900 dark:text-white bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-lg">
                            {{ $permiso->nombre }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">Módulo</label>
                            <span class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400">
                                {{ ucfirst($permiso->modulo) }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">Acción</label>
                            <div class="text-base font-semibold text-slate-900 dark:text-white">
                                {{ ucfirst($permiso->accion) }}
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">Descripción</label>
                        <div class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
                            {{ $permiso->descripcion ?? 'Sin descripción definida.' }}
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ route('admin.permisos.edit', $permiso->id) }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-amber-600 to-amber-500 text-white text-sm font-medium rounded-lg hover:from-amber-700 hover:to-amber-600 transition-all shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50">
                        <i class="fas fa-edit"></i>
                        <span>Editar Permiso</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column: Roles -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-user-shield text-cyan-500 text-lg"></i>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Roles Asignados</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">Perfiles con este acceso</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @forelse($permiso->roles as $rol)
                        <div class="flex items-center justify-between py-3 border-b border-slate-200 dark:border-slate-700 last:border-0">
                            <div>
                                <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $rol->nombre }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    {{ $rol->usuarios->count() }} Usuarios
                                </div>
                            </div>
                            <a href="{{ route('admin.roles.show', $rol->id) }}" class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300">
                                <i class="fas fa-arrow-right text-sm"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <i class="fas fa-unlink text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                            <p class="text-slate-600 dark:text-slate-400 text-sm">Este permiso no está asignado a ningún rol.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
