<div class="space-y-6">
    <!-- Entorno del Servidor -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-server text-rose-500"></i>
                <span class="text-white font-semibold">Entorno del Servidor</span>
            </div>
            <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fab fa-php"></i> Versión de PHP
                </label>
                <input type="text" value="{{ phpversion() }}" readonly class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-gray-400 opacity-70">
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fab fa-laravel"></i> Versión de Laravel
                </label>
                <input type="text" value="{{ app()->version() }}" readonly class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-gray-400 opacity-70">
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fas fa-hdd"></i> Driver de Caché
                </label>
                <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    <option selected>file (Local)</option>
                    <option>redis</option>
                    <option>memcached</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fas fa-cookie"></i> Driver de Sesión
                </label>
                <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    <option selected>file (Local)</option>
                    <option>database</option>
                    <option>cookie</option>
                </select>
            </div>

            <!-- Modo Debug -->
            <div class="col-span-full mt-4">
                <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                    <div>
                        <p class="text-white font-medium text-sm">Modo Debug (Desarrollo)</p>
                        <p class="text-gray-400 text-xs mt-0.5">Mostrar errores detallados. <strong class="text-rose-500">¡No activar en producción!</strong></p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="debug_mode" {{ config('app.debug') ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-green-500/20 text-green-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-check-double"></i> Estable
                </span>
                <span class="text-xs text-gray-500">Uptime: 72h</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Guardar Entorno
            </button>
        </div>
    </div>

    <!-- Diagnóstico y Mantenimiento -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-tools text-rose-500"></i>
                <span class="text-white font-semibold">Diagnóstico y Mantenimiento</span>
            </div>
            <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <!-- Registro de Errores -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                <div>
                    <p class="text-white font-medium text-sm">Registro de Errores (Logs)</p>
                    <p class="text-gray-400 text-xs mt-0.5">Guardar historial de excepciones y fallos del sistema.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="logging_enabled" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fas fa-broom"></i> Limpieza Automática
                </label>
                <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    <option>Semanalmente</option>
                    <option>Mensualmente</option>
                    <option>Nunca</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-blue-500/20 text-blue-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-wrench"></i> Mantenimiento
                </span>
                <span class="text-xs text-gray-500">Automatizado</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Guardar Configuración
            </button>
        </div>
    </div>
</div>
