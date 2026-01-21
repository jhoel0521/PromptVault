<x-app-layout>
    <x-slot:header>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-tr from-teal-500 to-green-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-key text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Nuevo Permiso</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">Registrar una nueva regla de acceso</p>
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
        <!-- Left Column: Guidelines -->
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <div class="flex items-start gap-4 mb-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-teal-100 dark:bg-teal-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cube text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white mb-1">Módulo</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400">Agrupa el permiso bajo una función (ej: Docentes, Reportes).</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-teal-100 dark:bg-teal-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white mb-1">Acción</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400">Verbo que describe la capacidad (ej: crear, editar, eliminar).</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('admin.permisos.store') }}" method="POST">
                @csrf
                
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-info-circle text-teal-500 text-lg"></i>
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Detalles del Permiso</h3>
                                <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">Información técnica</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        <!-- Nombre Clave -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Nombre Clave <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre') }}"
                                       class="w-full pl-11 pr-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-slate-800 text-slate-900 dark:text-white @error('nombre') border-red-500 @enderror" 
                                       placeholder="ej: docentes.crear"
                                       required>
                            </div>
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Módulo y Acción -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="modulo" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    Módulo <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-cubes absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                    <input type="text" 
                                           list="modulos-list" 
                                           id="modulo" 
                                           name="modulo" 
                                           value="{{ old('modulo') }}"
                                           class="w-full pl-11 pr-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-slate-800 text-slate-900 dark:text-white @error('modulo') border-red-500 @enderror" 
                                           placeholder="Seleccione o escriba..."
                                           required>
                                    <datalist id="modulos-list">
                                        @foreach($modulos as $modulo)
                                            <option value="{{ $modulo }}">
                                        @endforeach
                                    </datalist>
                                </div>
                                @error('modulo')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="accion" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    Acción <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-bolt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                    <input type="text" 
                                           list="acciones-list" 
                                           id="accion" 
                                           name="accion" 
                                           value="{{ old('accion') }}"
                                           class="w-full pl-11 pr-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-slate-800 text-slate-900 dark:text-white @error('accion') border-red-500 @enderror" 
                                           placeholder="Seleccione o escriba..."
                                           required>
                                    <datalist id="acciones-list">
                                        @foreach($acciones as $accion)
                                            <option value="{{ $accion }}">
                                        @endforeach
                                    </datalist>
                                </div>
                                @error('accion')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
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
                                          class="w-full pl-11 pr-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-slate-800 text-slate-900 dark:text-white @error('descripcion') border-red-500 @enderror" 
                                          placeholder="Describa qué permite hacer este permiso...">{{ old('descripcion') }}</textarea>
                            </div>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                            <i class="fas fa-plus-circle text-teal-500"></i>
                            <span>Nuevo Registro</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.permisos.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-teal-600 to-teal-500 text-white text-sm font-medium rounded-lg hover:from-teal-700 hover:to-teal-600 transition-all shadow-lg shadow-teal-500/30 hover:shadow-teal-500/50">
                                <i class="fas fa-save"></i>
                                <span>Guardar Permiso</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
