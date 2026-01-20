<x-app-layout>
    <div class="space-y-6">
        {{-- Header del Perfil --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-tr from-rose-500 to-pink-500 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-user-circle text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Mi Perfil</h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Gestiona tu información personal y seguridad de cuenta</p>
                    </div>
                </div>
                <a href="{{ route('perfil.edit') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                    <i class="fas fa-user-edit"></i>
                    <span>Editar Perfil</span>
                </a>
            </div>

            {{-- Stats Pills --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-id-card text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-600 dark:text-slate-400 block">Rol</span>
                        <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ Auth::user()->role ? Auth::user()->role->nombre : 'Usuario' }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-toggle-on text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-600 dark:text-slate-400 block">Estado</span>
                        <span class="text-sm font-semibold {{ Auth::user()->cuenta_activa ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ Auth::user()->cuenta_activa ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-600 dark:text-slate-400 block">Miembro Desde</span>
                        <span class="text-sm font-semibold text-slate-900 dark:text-white">
                            {{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y') : '-' }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-amber-600 dark:text-amber-400"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-600 dark:text-slate-400 block">Último Acceso</span>
                        <span class="text-sm font-semibold text-slate-900 dark:text-white">
                            {{ Auth::user()->ultimo_acceso ? Auth::user()->ultimo_acceso->diffForHumans() : 'Ahora' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid Principal: Tarjeta de Perfil + Dashboard --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Tarjeta de Perfil --}}
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 text-center" x-data="{ uploading: false }">
                    {{-- Avatar --}}
                    <div class="relative inline-block mb-4">
                        <img src="{{ Auth::user()->foto_perfil && file_exists(public_path(Auth::user()->foto_perfil)) ? asset(Auth::user()->foto_perfil) . '?v=' . time() : asset('images/default-avatar.svg') }}" 
                             alt="Foto de Perfil" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-slate-200 dark:border-slate-700 shadow-lg">
                        <a href="{{ route('perfil.edit') }}" 
                           class="absolute bottom-0 right-0 w-10 h-10 bg-gradient-to-r from-rose-600 to-pink-600 rounded-full flex items-center justify-center text-white hover:from-rose-700 hover:to-pink-700 transition-all shadow-lg"
                           title="Ir a editar perfil para cambiar foto">
                            <i class="fas fa-camera text-sm"></i>
                        </a>
                    </div>

                    <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-1">{{ Auth::user()->name }}</h2>
                    <span class="inline-block px-3 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-sm font-medium rounded-full mb-2">
                        {{ Auth::user()->role ? Auth::user()->role->nombre : 'Usuario' }}
                    </span>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">{{ Auth::user()->email }}</p>

                    {{-- Stats Compactos --}}
                    <div class="grid grid-cols-2 gap-4 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl">
                        <div>
                            <div class="text-lg font-bold text-slate-900 dark:text-white">
                                {{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y') : '-' }}
                            </div>
                            <div class="text-xs text-slate-600 dark:text-slate-400">Miembro Desde</div>
                        </div>
                        <div>
                            <div class="text-lg font-bold {{ Auth::user()->cuenta_activa ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ Auth::user()->cuenta_activa ? 'Activo' : 'Inactivo' }}
                            </div>
                            <div class="text-xs text-slate-600 dark:text-slate-400">Estado</div>
                        </div>
                    </div>

                    <div class="mt-4 text-xs text-slate-500 dark:text-slate-400">
                        Último acceso: {{ Auth::user()->ultimo_acceso ? Auth::user()->ultimo_acceso->diffForHumans() : 'Nunca' }}
                    </div>
                </div>
            </div>

            {{-- Dashboard de Información --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Información Personal --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Información Personal</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Resumen de tus datos registrados</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs text-slate-600 dark:text-slate-400 block mb-1">Nombre Completo</label>
                            <span class="text-base font-semibold text-slate-900 dark:text-white">{{ Auth::user()->name }}</span>
                        </div>
                        <div>
                            <label class="text-xs text-slate-600 dark:text-slate-400 block mb-1">Correo Electrónico</label>
                            <span class="text-base font-semibold text-slate-900 dark:text-white">{{ Auth::user()->email }}</span>
                        </div>
                        <div>
                            <label class="text-xs text-slate-600 dark:text-slate-400 block mb-1">Rol del Sistema</label>
                            <span class="text-base font-semibold text-slate-900 dark:text-white">
                                {{ Auth::user()->role ? ucfirst(Auth::user()->role->nombre) : 'Usuario' }}
                            </span>
                        </div>
                        <div>
                            <label class="text-xs text-slate-600 dark:text-slate-400 block mb-1">Estado de Cuenta</label>
                            <span class="text-base font-semibold {{ Auth::user()->cuenta_activa ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ Auth::user()->cuenta_activa ? 'Activa' : 'Inactiva' }}
                            </span>
                        </div>
                        <div>
                            <label class="text-xs text-slate-600 dark:text-slate-400 block mb-1">Registro en el Sistema</label>
                            <span class="text-base font-semibold text-slate-900 dark:text-white">
                                {{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y H:i') : 'N/A' }}
                            </span>
                        </div>
                        <div>
                            <label class="text-xs text-slate-600 dark:text-slate-400 block mb-1">Email Verificado</label>
                            <span class="text-base font-semibold text-slate-900 dark:text-white">
                                {{ Auth::user()->email_verified_at ? 'Sí (' . Auth::user()->email_verified_at->format('d/m/Y') . ')' : 'No verificado' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('perfil.edit') }}" class="flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-user-edit text-xl"></i>
                        <span class="font-semibold">Editar Perfil</span>
                    </a>

                    <a href="{{ route('perfil.security') }}" class="flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-shield-alt text-xl"></i>
                        <span class="font-semibold">Seguridad</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Actividad Reciente --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-history text-purple-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Actividad Reciente</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Últimos movimientos en el sistema</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($logs ?? [] as $log)
                    <div class="flex items-start gap-4 pb-4 border-b border-slate-200 dark:border-slate-700 last:border-0 last:pb-0">
                        <div class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-dot-circle text-rose-600 dark:text-rose-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-slate-900 dark:text-white mb-1">
                                {{ $log->accion }} - {{ $log->modulo }}
                            </h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400">
                                {{ $log->ip_address }} &bull; {{ $log->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-history text-2xl text-slate-400 dark:text-slate-600"></i>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400">No hay actividad reciente</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

