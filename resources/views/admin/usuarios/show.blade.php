<x-app-layout>
    <x-slot:header>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-tr from-rose-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Detalles del Usuario</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $usuario->name }}</p>
                </div>
            </div>
            <a href="{{ route('admin.usuarios.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Sidebar --}}
        <div class="space-y-6">
            {{-- Profile Card --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <div class="flex flex-col items-center">
                    <x-user-avatar :user="$usuario" size="2xl" />
                    <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">{{ ucfirst($usuario->role?->nombre ?? 'Sin rol') }}</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $usuario->email }}</p>
                    
                    {{-- Quick Stats --}}
                    <div class="w-full mt-6 space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-slate-200 dark:border-slate-700">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Estado</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $usuario->cuenta_activa ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }}">
                                {{ $usuario->cuenta_activa ? 'Activa' : 'Inactiva' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Prompts Creados</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $usuario->prompts_count ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Personal Info --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <i class="fas fa-user text-rose-600"></i>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Información Personal</h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nombre Completo</label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" value="{{ $usuario->name }}" readonly
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Account Info --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <i class="fas fa-user-shield text-rose-600"></i>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Datos de Cuenta</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Correo Electrónico</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="email" value="{{ $usuario->email }}" readonly
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Rol</label>
                        <div class="relative">
                            <i class="fas fa-user-tag absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" value="{{ ucfirst($usuario->role?->nombre ?? 'Sin rol') }}" readonly
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Último Acceso</label>
                        <div class="relative">
                            <i class="fas fa-clock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" value="{{ $usuario->ultimo_acceso ? \Carbon\Carbon::parse($usuario->ultimo_acceso)->format('d/m/Y H:i') : 'Nunca' }}" readonly
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Fecha de Registro</label>
                        <div class="relative">
                            <i class="fas fa-calendar-plus absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" value="{{ $usuario->created_at->format('d/m/Y H:i') }}" readonly
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-700 dark:text-slate-300">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end">
                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-700 hover:to-amber-600 text-white font-medium rounded-lg shadow-sm transition-all">
                    <i class="fas fa-edit"></i>
                    <span>Editar Usuario</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>