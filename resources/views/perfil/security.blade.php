<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-tr from-red-600 to-red-800 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Seguridad</h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Gestiona tu contraseña y protección de cuenta</p>
                    </div>
                </div>
                <a href="{{ route('perfil.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border-2 border-rose-600 text-rose-600 dark:text-rose-400 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all duration-200">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver al Perfil</span>
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
                        <span class="text-sm font-semibold text-green-600 dark:text-green-400">Activo</span>
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

        {{-- Grid Principal: Sidebar + Formulario --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            {{-- Sidebar Sticky (idéntico a edit) --}}
            <div class="lg:col-span-1 space-y-0 lg:sticky lg:top-6 lg:self-start">
                {{-- Card Avatar --}}
                <div class="bg-white dark:bg-slate-900 rounded-t-2xl shadow-sm border border-slate-200 dark:border-slate-700 border-b-0 p-4 text-center">
                    <div class="relative inline-block mb-3">
                        <img src="{{ Auth::user()->foto_perfil && file_exists(public_path(Auth::user()->foto_perfil)) ? asset(Auth::user()->foto_perfil) : asset('images/default-avatar.svg') }}" 
                             alt="Foto de Perfil" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-slate-200 dark:border-slate-700 shadow-lg">
                        <div class="absolute bottom-0 right-0 w-10 h-10 bg-gradient-to-r from-slate-400 to-slate-500 rounded-full flex items-center justify-center text-white opacity-50 cursor-default" 
                             title="Ir a editar perfil para cambiar foto">
                            <i class="fas fa-camera text-sm"></i>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-1">{{ Auth::user()->name }}</h2>
                    <span class="inline-block px-3 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-sm font-medium rounded-full mb-2">
                        {{ Auth::user()->role ? Auth::user()->role->nombre : 'Usuario' }}
                    </span>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-3">{{ Auth::user()->email }}</p>

                    <div class="grid grid-cols-2 gap-4 p-3 bg-slate-50 dark:bg-slate-800 rounded-xl mb-3">
                        <div>
                            <div class="text-lg font-bold text-slate-900 dark:text-white">
                                {{ Auth::user()->created_at ? Auth::user()->created_at->diffInDays() : 0 }}
                            </div>
                            <div class="text-xs text-slate-600 dark:text-slate-400">Días</div>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-green-600 dark:text-green-400">Activo</div>
                            <div class="text-xs text-slate-600 dark:text-slate-400">Estado</div>
                        </div>
                    </div>

                    <div class="pt-3">
                        <a href="{{ route('perfil.edit') }}" class="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white rounded-lg transition-all duration-200">
                            <i class="fas fa-user-edit"></i>
                            <span class="text-sm font-medium">Editar Perfil</span>
                        </a>
                    </div>
                </div>

                {{-- Card Nivel de Perfil (idéntico a edit) --}}
                <div class="bg-white dark:bg-slate-900 rounded-b-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-200 dark:border-slate-700">
                        <div class="w-10 h-10 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-rose-600 dark:text-rose-400"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Nivel de Perfil</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400">Estadísticas de cuenta</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between text-xs font-medium mb-2">
                            <span class="text-slate-900 dark:text-white">Intermedio</span>
                            <span class="text-rose-600 dark:text-rose-400">85%</span>
                        </div>
                        <div class="w-full h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="w-[85%] h-full bg-gradient-to-r from-rose-600 to-pink-600 shadow-[0_0_10px_rgba(220,38,38,0.4)]"></div>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">
                            <i class="fas fa-info-circle"></i> Completa tu biografía para llegar al 100%.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-slate-50 dark:bg-slate-800 p-3 rounded-lg text-center">
                            <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl mb-1"></i>
                            <span class="block text-xs text-slate-600 dark:text-slate-400">Email</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">Verificado</span>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-800 p-3 rounded-lg text-center">
                            <i class="fas fa-shield-alt text-amber-600 dark:text-amber-400 text-xl mb-1"></i>
                            <span class="block text-xs text-slate-600 dark:text-slate-400">Seguridad</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">Alta</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-200 dark:border-slate-700 space-y-3">
                        <h4 class="text-xs text-slate-600 dark:text-slate-400 uppercase font-bold">Detalles de Cuenta</h4>
                        
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-600 dark:text-slate-400"><i class="fas fa-fingerprint w-4"></i> ID Usuario</span>
                            <span class="text-slate-900 dark:text-white font-mono bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">#{{ str_pad(Auth::user()->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-600 dark:text-slate-400"><i class="fas fa-globe-americas w-4"></i> Región</span>
                            <span class="text-slate-900 dark:text-white">Bolivia (BOT)</span>
                        </div>

                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-600 dark:text-slate-400"><i class="fas fa-key w-4"></i> 2FA</span>
                            <button class="px-3 py-1 bg-gradient-to-r from-rose-600 to-pink-600 text-white text-xs rounded-lg hover:from-rose-700 hover:to-pink-700">
                                Activar <i class="fas fa-chevron-right text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Formulario Seguridad --}}
            <div class="lg:col-span-3 space-y-6">
                {{-- Formulario Cambiar Contraseña --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-lock text-red-600 dark:text-red-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Cambiar Contraseña</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Actualiza y fortalece la seguridad de tu cuenta</p>
                        </div>
                    </div>

                    <form action="{{ route('perfil.password') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6 mb-6">
                            <div>
                                <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    <i class="fas fa-key text-slate-500"></i> Contraseña Actual
                                </label>
                                <div class="relative" x-data="{ show: false }">
                                    <input :type="show ? 'text' : 'password'" 
                                           name="current_password" 
                                           class="w-full px-4 py-3 pr-12 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all" 
                                           placeholder="Ingresa tu contraseña actual" 
                                           required>
                                    <button type="button" 
                                            @click="show = !show" 
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                                        <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        <i class="fas fa-lock text-slate-500"></i> Nueva Contraseña
                                    </label>
                                    <div class="relative" x-data="{ show: false }">
                                        <input :type="show ? 'text' : 'password'" 
                                               name="new_password" 
                                               class="w-full px-4 py-3 pr-12 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all" 
                                               placeholder="Mínimo 6 caracteres" 
                                               required>
                                        <button type="button" 
                                                @click="show = !show" 
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                                            <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        <i class="fas fa-check-circle text-slate-500"></i> Confirmar Contraseña
                                    </label>
                                    <div class="relative" x-data="{ show: false }">
                                        <input :type="show ? 'text' : 'password'" 
                                               name="new_password_confirmation" 
                                               class="w-full px-4 py-3 pr-12 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all" 
                                               placeholder="Repite la nueva contraseña" 
                                               required>
                                        <button type="button" 
                                                @click="show = !show" 
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                                            <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                            <a href="{{ route('perfil.index') }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 border-2 border-rose-600 text-rose-600 dark:text-rose-400 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all duration-200 font-semibold">
                                <i class="fas fa-times"></i>
                                <span>Cancelar</span>
                            </a>

                            <button type="submit" class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl font-semibold">
                                <i class="fas fa-shield-alt"></i>
                                <span>Actualizar Contraseña</span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Card Recomendaciones --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-shield text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Recomendaciones de Seguridad</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Mantén tu cuenta protegida en todo momento</p>
                        </div>
                    </div>

                    <ul class="space-y-4">
                        <li class="flex gap-3 items-start">
                            <i class="fas fa-check text-green-600 dark:text-green-400 mt-1"></i>
                            <div>
                                <strong class="block text-sm text-slate-900 dark:text-white">Usa una contraseña única</strong>
                                <span class="text-xs text-slate-600 dark:text-slate-400">No reutilices contraseñas de otros sitios.</span>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <i class="fas fa-check text-green-600 dark:text-green-400 mt-1"></i>
                            <div>
                                <strong class="block text-sm text-slate-900 dark:text-white">Activa la autenticación de dos factores (2FA)</strong>
                                <span class="text-xs text-slate-600 dark:text-slate-400">Añade una capa extra de seguridad a tu login.</span>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <i class="fas fa-check text-green-600 dark:text-green-400 mt-1"></i>
                            <div>
                                <strong class="block text-sm text-slate-900 dark:text-white">Cierra sesión en dispositivos compartidos</strong>
                                <span class="text-xs text-slate-600 dark:text-slate-400">Asegúrate de no dejar tu cuenta abierta en equipos públicos.</span>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <i class="fas fa-bell text-green-600 dark:text-green-400 mt-1"></i>
                            <div>
                                <strong class="block text-sm text-slate-900 dark:text-white">Alertas de Inicio de Sesión</strong>
                                <span class="text-xs text-slate-600 dark:text-slate-400">Recibe notificaciones ante accesos sospechosos.</span>
                            </div>
                        </li>
                        <li class="flex justify-between items-center pt-4 mt-4 border-t border-slate-200 dark:border-slate-700">
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">Historial de Actividad</span>
                            <a href="#" class="inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white text-xs rounded-lg transition-all duration-200">
                                Ver Todo <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
