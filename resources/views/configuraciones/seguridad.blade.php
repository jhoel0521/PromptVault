<div class="space-y-6">
    <!-- Políticas de Acceso -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-shield-alt text-rose-500"></i>
                <span class="text-white font-semibold">Políticas de Acceso</span>
            </div>
            <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <!-- Autenticación 2FA -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                <div>
                    <p class="text-white font-medium text-sm">Autenticación de Dos Factores (2FA)</p>
                    <p class="text-gray-400 text-xs mt-0.5">Requerir código de verificación para administradores.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="2fa_auth" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-stopwatch"></i> Timeout de Sesión (min)
                    </label>
                    <input type="number" value="120" class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-user-lock"></i> Intentos Fallidos
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>3 Intentos</option>
                        <option>5 Intentos</option>
                        <option>10 Intentos</option>
                    </select>
                </div>
            </div>

            <!-- Bloqueo Geográfico -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10 mt-4">
                <div>
                    <p class="text-white font-medium text-sm">Bloqueo Geográfico</p>
                    <p class="text-gray-400 text-xs mt-0.5">Permitir acceso solo desde regiones autorizadas (Bolivia).</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="geo_block" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-green-500/20 text-green-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-shield-check"></i> Protegido
                </span>
                <span class="text-xs text-gray-500">Monitoreo Activo</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Guardar Políticas
            </button>
        </div>
    </div>

    <!-- Seguridad de Contraseñas -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-key text-rose-500"></i>
                <span class="text-white font-semibold">Seguridad de Contraseñas</span>
            </div>
            <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-ruler-horizontal"></i> Longitud Mínima
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>8 Caracteres</option>
                        <option selected>12 Caracteres</option>
                        <option>16 Caracteres</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-clock"></i> Expiración (Días)
                    </label>
                    <input type="number" value="90" class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                </div>
            </div>

            <!-- Caracteres Especiales -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10 mt-4">
                <div>
                    <p class="text-white font-medium text-sm">Caracteres Especiales</p>
                    <p class="text-gray-400 text-xs mt-0.5">Forzar uso de símbolos (!@#$) y números en contraseñas nuevas.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="special_chars" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>

            <!-- Forzar Renovación -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                <div>
                    <p class="text-white font-medium text-sm">Forzar Renovación</p>
                    <p class="text-gray-400 text-xs mt-0.5">Requerir cambio de contraseña en el próximo inicio de sesión.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="force_rotation" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-yellow-500/20 text-yellow-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-lock"></i> Políticas Activas
                </span>
                <span class="text-xs text-gray-500">Aplicadas</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Guardar Configuración
            </button>
        </div>
    </div>
</div>
