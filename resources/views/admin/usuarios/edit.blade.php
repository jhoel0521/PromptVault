<x-app-layout>
    <x-slot:header>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-tr from-amber-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-edit text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Editar Usuario</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Actualice los datos del usuario</p>
                </div>
            </div>
            <a href="{{ route('admin.usuarios.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>
    </x-slot:header>

    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data" 
          x-data="{
              currentPhoto: '{{ $usuario->foto_perfil ? asset('storage/' . $usuario->foto_perfil) : '' }}',
              previewImage(event) {
                  const file = event.target.files[0];
                  if (file) {
                      const reader = new FileReader();
                      reader.onload = (e) => {
                          this.currentPhoto = e.target.result;
                      };
                      reader.readAsDataURL(file);
                  }
              }
          }" 
          class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Sidebar --}}
            <div class="space-y-6">
                {{-- Avatar Upload --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <div class="flex flex-col items-center">
                        <div class="relative w-32 h-32 mb-4">
                            <template x-if="currentPhoto">
                                <img :src="currentPhoto" alt="Avatar" class="w-32 h-32 rounded-full object-cover">
                            </template>
                            <template x-if="!currentPhoto">
                                <div class="w-32 h-32 bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-4xl text-slate-400 dark:text-slate-500"></i>
                                </div>
                            </template>
                        </div>
                        <label for="avatar" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg transition-colors">
                            <i class="fas fa-camera"></i>
                            <span>Cambiar Foto</span>
                        </label>
                        <input type="file" id="avatar" name="foto_perfil" @change="previewImage" accept="image/*" class="hidden">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Deje vacío para mantener la actual</p>
                    </div>
                </div>

                {{-- Info Cards --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 space-y-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shield-alt text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900 dark:text-white">Rol Actual</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400">{{ ucfirst($usuario->role?->nombre ?? 'Sin rol') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-lock text-amber-600 dark:text-amber-400"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900 dark:text-white">Contraseña</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400">Dejar vacío para mantener actual</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Personal Info --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fas fa-user text-amber-600"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Información Personal</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Datos básicos del usuario</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Nombre Completo <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" id="name" name="name" value="{{ old('name', $usuario->name) }}" required
                                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                       placeholder="Ej: Juan Pérez">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Account Info --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fas fa-user-shield text-amber-600"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Datos de Cuenta</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Credenciales y Acceso</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Correo Electrónico <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}" required
                                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                       placeholder="usuario@ejemplo.com">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Contraseña (Opcional)
                            </label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="password" id="password" name="password"
                                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                       placeholder="Dejar vacío para mantener">
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="role_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Rol en el Sistema <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-user-tag absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                <select id="role_id" name="role_id" required
                                        class="w-full pl-10 pr-8 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-amber-500 appearance-none cursor-pointer">
                                    <option value="">Seleccione un rol...</option>
                                    @foreach($roles ?? [] as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id', $usuario->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->nombre) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('role_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cuenta_activa" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                Estado de Cuenta
                            </label>
                            <div class="relative">
                                <i class="fas fa-toggle-on absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                <select id="cuenta_activa" name="cuenta_activa"
                                        class="w-full pl-10 pr-8 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-amber-500 appearance-none cursor-pointer">
                                    <option value="1" {{ old('cuenta_activa', $usuario->cuenta_activa) == 1 ? 'selected' : '' }}>Activa</option>
                                    <option value="0" {{ old('cuenta_activa', $usuario->cuenta_activa) == 0 ? 'selected' : '' }}>Inactiva</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-between bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                    <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <i class="fas fa-edit"></i>
                        <span>Modo Edición</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.usuarios.index') }}" 
                           class="px-4 py-2 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-700 hover:to-amber-600 text-white font-medium rounded-lg shadow-sm transition-all">
                            <i class="fas fa-save"></i>
                            <span>Actualizar Usuario</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
