<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-tr from-rose-500 to-pink-500 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-user-edit text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Editar Perfil</h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Actualiza tu información personal y configuración</p>
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
            {{-- Sidebar Sticky --}}
            <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-6 lg:self-start">
                {{-- Card Avatar --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 text-center" x-data="{ uploading: false }">
                    <div class="relative inline-block mb-4">
                        <img src="{{ Auth::user()->foto_perfil && file_exists(public_path(Auth::user()->foto_perfil)) ? asset(Auth::user()->foto_perfil) : asset('images/default-avatar.svg') }}" 
                             alt="Foto de Perfil" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-slate-200 dark:border-slate-700 shadow-lg"
                             id="avatarPreview">
                        <label for="avatarInput" 
                               class="absolute bottom-0 right-0 w-10 h-10 bg-gradient-to-r from-rose-600 to-pink-600 rounded-full flex items-center justify-center text-white cursor-pointer hover:from-rose-700 hover:to-pink-700 transition-all shadow-lg"
                               title="Cambiar foto">
                            <i class="fas fa-camera text-sm"></i>
                        </label>
                        <form id="avatarForm" action="{{ route('perfil.avatar') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                            @csrf
                            <input type="file" id="avatarInput" name="avatar" accept="image/*">
                        </form>
                    </div>

                    <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-1">{{ Auth::user()->name }}</h2>
                    <span class="inline-block px-3 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-sm font-medium rounded-full mb-2">
                        {{ Auth::user()->role ? Auth::user()->role->nombre : 'Usuario' }}
                    </span>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">{{ Auth::user()->email }}</p>

                    <div class="grid grid-cols-2 gap-4 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl mb-4">
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

                    <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                        <h4 class="text-xs text-slate-600 dark:text-slate-400 uppercase font-bold mb-3">Seguridad</h4>
                        <a href="{{ route('perfil.security') }}" class="flex items-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg transition-all duration-200">
                            <i class="fas fa-lock"></i>
                            <span class="text-sm font-medium">Cambiar Contraseña</span>
                        </a>
                    </div>
                </div>

                {{-- Card Nivel de Perfil --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-rose-600 dark:text-rose-400"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Nivel de Perfil</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400">Estadísticas</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between text-xs font-medium mb-2">
                            <span class="text-slate-900 dark:text-white">Intermedio</span>
                            <span class="text-rose-600 dark:text-rose-400">85%</span>
                        </div>
                        <div class="w-full h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="w-[85%] h-full bg-gradient-to-r from-rose-600 to-pink-600"></div>
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

            {{-- Formulario Principal --}}
            <div class="lg:col-span-3">
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-edit text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Información Personal</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Actualiza tu información personal y redes sociales</p>
                        </div>
                    </div>

                    <form action="{{ route('perfil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Datos Básicos --}}
                        <div class="mb-8">
                            <h4 class="flex items-center gap-2 text-rose-600 dark:text-rose-400 font-bold mb-4">
                                <i class="fas fa-address-card"></i>
                                <span>Datos Básicos</span>
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        <i class="fas fa-user text-slate-500"></i> Nombre Completo
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           value="{{ old('name', Auth::user()->name) }}" 
                                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all" 
                                           required>
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        <i class="fas fa-envelope text-slate-500"></i> Correo Electrónico
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           value="{{ old('email', Auth::user()->email) }}" 
                                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all" 
                                           required>
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Alerta Info Rol --}}
                        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded-lg mb-8">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mt-0.5"></i>
                                <span class="text-sm text-slate-700 dark:text-slate-300">
                                    Tu rol en el sistema es <strong>{{ Auth::user()->role ? ucfirst(Auth::user()->role->nombre) : 'Usuario' }}</strong>. Solo un administrador puede cambiar roles.
                                </span>
                            </div>
                        </div>

                        {{-- Estado de Cuenta --}}
                        <div class="mb-8 pt-8 border-t border-slate-200 dark:border-slate-700">
                            <h4 class="flex items-center gap-2 text-rose-600 dark:text-rose-400 font-bold mb-4">
                                <i class="fas fa-shield-alt"></i>
                                <span>Estado de Cuenta</span>
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        <i class="fas fa-toggle-on text-slate-500"></i> Estado de la Cuenta
                                    </label>
                                    <select disabled class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white cursor-not-allowed">
                                        <option value="1" {{ Auth::user()->cuenta_activa ? 'selected' : '' }}>Activa</option>
                                        <option value="0" {{ !Auth::user()->cuenta_activa ? 'selected' : '' }}>Inactiva</option>
                                    </select>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                        <i class="fas fa-lock"></i> Solo un administrador puede cambiar el estado de tu cuenta
                                    </p>
                                </div>

                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        <i class="fas fa-calendar text-slate-500"></i> Miembro Desde
                                    </label>
                                    <input type="text" 
                                           value="{{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y H:i') : 'N/A' }}" 
                                           class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white cursor-not-allowed" 
                                           disabled>
                                </div>
                            </div>
                        </div>

                        {{-- Información del Sistema --}}
                        <div class="mb-8 pt-8 border-t border-slate-200 dark:border-slate-700">
                            <h4 class="flex items-center gap-2 text-rose-600 dark:text-rose-400 font-bold mb-4">
                                <i class="fas fa-info-circle"></i>
                                <span>Información del Sistema</span>
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        <i class="fas fa-globe text-slate-500"></i> Website
                                    </label>
                                    <input type="url" 
                                           name="website" 
                                           value="{{ old('website', Auth::user()->website ?? '') }}" 
                                           placeholder="https://" 
                                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all">
                                </div>

                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        <i class="fas fa-calendar-check text-slate-500"></i> Último Acceso
                                    </label>
                                    <input type="text" 
                                           value="{{ Auth::user()->ultimo_acceso ? Auth::user()->ultimo_acceso->format('d/m/Y H:i') : 'Nunca' }}" 
                                           class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white cursor-not-allowed" 
                                           disabled>
                                </div>

                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                        <i class="fas fa-envelope-open-text text-slate-500"></i> Email Verificado
                                    </label>
                                    <input type="text" 
                                           value="{{ Auth::user()->email_verified_at ? 'Sí (' . Auth::user()->email_verified_at->format('d/m/Y') . ')' : 'No verificado' }}" 
                                           class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white cursor-not-allowed" 
                                           disabled>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                            <a href="{{ route('perfil.index') }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 border-2 border-rose-600 text-rose-600 dark:text-rose-400 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all duration-200 font-semibold">
                                <i class="fas fa-times"></i>
                                <span>Cancelar</span>
                            </a>

                            <button type="submit" class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl font-semibold">
                                <i class="fas fa-save"></i>
                                <span>Guardar Cambios</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Avatar upload con preview
        document.getElementById('avatarInput')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validar tipo
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Solo se permiten imágenes (JPEG, PNG, GIF, WEBP)');
                return;
            }

            // Validar tamaño (2MB)
            if (file.size > 2048 * 1024) {
                alert('La imagen no puede superar los 2MB');
                return;
            }

            // Preview inmediato
            const reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById('avatarPreview').src = event.target.result;
            };
            reader.readAsDataURL(file);

            // Upload AJAX
            const formData = new FormData();
            formData.append('avatar', file);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch('{{ route("perfil.avatar") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-xl z-50';
                    toast.innerHTML = '<i class="fas fa-check-circle mr-2"></i>' + (data.message || 'Foto actualizada');
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);
                } else {
                    alert('Error: ' + (data.message || 'Error desconocido'));
                    location.reload();
                }
            })
            .catch(error => {
                alert('Error de conexión');
                location.reload();
            });
        });
    </script>
    @endpush
</x-app-layout>
