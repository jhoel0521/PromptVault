<x-configuraciones-layout>
    <div class="space-y-6">
        <form action="{{ route('admin.configuraciones.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Políticas de Acceso -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-shield-alt text-rose-500"></i>
                        <span class="text-white font-semibold">Políticas de Acceso</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 mb-6">
                    <!-- Autenticación 2FA -->
                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                        <div>
                            <p class="text-white font-medium text-sm">Autenticación de Dos Factores (2FA)</p>
                            <p class="text-gray-400 text-xs mt-0.5">Requerir código de verificación para administradores.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="two_fa_enabled" value="1" {{ $settings->two_fa_enabled ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-form-label icon="stopwatch">Timeout de Sesión (min)</x-form-label>
                            <input type="number" name="session_timeout" value="{{ $settings->session_timeout }}" min="5" max="1440"
                                class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        </div>

                        <div>
                            <x-form-label icon="user-lock">Intentos Fallidos</x-form-label>
                            <x-form-select name="max_login_attempts">
                                <option value="3" {{ $settings->max_login_attempts == 3 ? 'selected' : '' }}>3 Intentos</option>
                                <option value="5" {{ $settings->max_login_attempts == 5 ? 'selected' : '' }}>5 Intentos</option>
                                <option value="10" {{ $settings->max_login_attempts == 10 ? 'selected' : '' }}>10 Intentos</option>
                            </x-form-select>
                        </div>
                    </div>

                    <!-- Bloqueo Geográfico -->
                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10 mt-4">
                        <div>
                            <p class="text-white font-medium text-sm">Bloqueo Geográfico</p>
                            <p class="text-gray-400 text-xs mt-0.5">Permitir acceso solo desde regiones autorizadas (Bolivia).</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="geo_blocking_enabled" value="1" {{ $settings->geo_blocking_enabled ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-white/10">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-green-500/20 text-green-500 text-xs rounded-full flex items-center gap-1.5">
                            <i class="fas fa-shield-check"></i> Protegido
                        </span>
                    </div>
                </div>
            </div>

            <!-- Seguridad de Contraseñas -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-key text-rose-500"></i>
                        <span class="text-white font-semibold">Seguridad de Contraseñas</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-form-label icon="ruler-horizontal">Longitud Mínima</x-form-label>
                            <x-form-select name="password_min_length">
                                <option value="8" {{ $settings->password_min_length == 8 ? 'selected' : '' }}>8 Caracteres</option>
                                <option value="12" {{ $settings->password_min_length == 12 ? 'selected' : '' }}>12 Caracteres</option>
                                <option value="16" {{ $settings->password_min_length == 16 ? 'selected' : '' }}>16 Caracteres</option>
                            </x-form-select>
                        </div>

                        <div>
                            <x-form-label icon="clock">Expiración (Días)</x-form-label>
                            <input type="number" name="password_expiry_days" value="{{ $settings->password_expiry_days }}" min="1" max="365"
                                class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        </div>
                    </div>

                    <!-- Caracteres Especiales -->
                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10 mt-4">
                        <div>
                            <p class="text-white font-medium text-sm">Caracteres Especiales</p>
                            <p class="text-gray-400 text-xs mt-0.5">Forzar uso de símbolos (!@#$) y números en contraseñas nuevas.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="password_require_special_chars" value="1" {{ $settings->password_require_special_chars ? 'checked' : '' }} class="sr-only peer">
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
                            <input type="checkbox" name="password_force_rotation" value="1" {{ $settings->password_force_rotation ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-white/10">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-yellow-500/20 text-yellow-500 text-xs rounded-full flex items-center gap-1.5">
                            <i class="fas fa-lock"></i> Políticas Activas
                        </span>
                    </div>
                    <button type="submit" class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                        <i class="fas fa-save"></i> Guardar Configuración
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-configuraciones-layout>
