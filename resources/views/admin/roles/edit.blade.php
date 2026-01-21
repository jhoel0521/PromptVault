<x-app-layout>
    <x-slot:header>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-tr from-amber-500 to-orange-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-edit text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Editar Rol</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $role->nombre }}</p>
            </div>
        </div>
        <div class="ml-auto">
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a Lista</span>
            </a>
        </div>
    </x-slot:header>

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST"
          x-data="{
              selectAllModule(event, module) {
                  const checkboxes = event.target.closest('.module-card').querySelectorAll('input[type=checkbox]');
                  const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                  checkboxes.forEach(cb => cb.checked = !allChecked);
                  event.target.textContent = !allChecked ? 'Deseleccionar Todo' : 'Seleccionar Todo';
              }
          }">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Card 1: Información Básica -->
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-info-circle text-amber-500 text-lg"></i>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Información Básica</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">Datos principales del rol</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-5">
                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Nombre del Rol <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre', $role->nombre) }}"
                                   class="w-full pl-11 pr-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-white dark:bg-slate-800 text-slate-900 dark:text-white @error('nombre') border-red-500 @enderror" 
                                   placeholder="Ej: Gestor de Laboratorios"
                                   required>
                        </div>
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Descripción
                        </label>
                        <div class="relative">
                            <i class="fas fa-align-left absolute left-4 top-4 text-slate-400"></i>
                            <textarea id="descripcion" 
                                      name="descripcion" 
                                      rows="3"
                                      class="w-full pl-11 pr-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-white dark:bg-slate-800 text-slate-900 dark:text-white @error('descripcion') border-red-500 @enderror" 
                                      placeholder="Breve descripción de las responsabilidades de este rol...">{{ old('descripcion', $role->descripcion) }}</textarea>
                        </div>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($role->es_sistema)
                        <div class="flex items-center gap-2 px-4 py-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"></i>
                            <span class="text-sm text-blue-700 dark:text-blue-300">Este es un rol de sistema. Algunos permisos pueden ser críticos.</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card 2: Permisos -->
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-key text-amber-500 text-lg"></i>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Permisos del Sistema</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">Seleccione los accesos permitidos</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @php
                        $rolePermissions = $role->permisos->pluck('id')->toArray();
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($permisosGrouped as $modulo => $permisos)
                            <div class="module-card border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden">
                                <div class="px-4 py-3 bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ ucfirst($modulo) }}</span>
                                    <button type="button" 
                                            @click="selectAllModule($event, '{{ $modulo }}')"
                                            class="text-xs text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 font-medium">
                                        Seleccionar Todo
                                    </button>
                                </div>
                                <div class="p-4 space-y-2">
                                    @foreach($permisos as $permiso)
                                        <label class="flex items-center gap-2 cursor-pointer group">
                                            <input type="checkbox" 
                                                   name="permisos[]" 
                                                   value="{{ $permiso->id }}" 
                                                   id="permiso_{{ $permiso->id }}"
                                                   {{ in_array($permiso->id, $rolePermissions) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-amber-600 border-slate-300 dark:border-slate-600 rounded focus:ring-2 focus:ring-amber-500 dark:bg-slate-800">
                                            <span class="text-sm text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white">{{ $permiso->nombre }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <i class="fas fa-shield-alt text-amber-500"></i>
                        <span>Modo Edición</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-amber-600 to-amber-500 text-white text-sm font-medium rounded-lg hover:from-amber-700 hover:to-amber-600 transition-all shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50">
                            <i class="fas fa-save"></i>
                            <span>Actualizar Rol</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
