<div class="space-y-6">
    <!-- Canales de Comunicación -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-broadcast-tower text-rose-500"></i>
                <span class="text-white font-semibold">Canales de Comunicación</span>
            </div>
            <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <!-- Notificaciones por Correo -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                <div>
                    <p class="text-white font-medium text-sm">Notificaciones por Correo</p>
                    <p class="text-gray-400 text-xs mt-0.5">Enviar resúmenes diarios y alertas de seguridad.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="email_notif" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-envelope-open-text"></i> Email de Destino
                    </label>
                    <input type="email" value="admin@tech-home.edu.bo" class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-bell"></i> Sonido de Alerta
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>Tech Home Chime</option>
                        <option>Subtle Ping</option>
                        <option>Silencio</option>
                    </select>
                </div>
            </div>

            <!-- Alertas Push (Navegador) -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10 mt-4">
                <div>
                    <p class="text-white font-medium text-sm">Alertas Push (Navegador)</p>
                    <p class="text-gray-400 text-xs mt-0.5">Mostrar pop-ups flotantes mientras se usa el sistema.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="push_notif" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-green-500/20 text-green-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-satellite-dish"></i> En Línea
                </span>
                <span class="text-xs text-gray-500">SMTP Configurado</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Guardar Canales
            </button>
        </div>
    </div>

    <!-- Reglas de Alerta -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-filter text-rose-500"></i>
                <span class="text-white font-semibold">Reglas de Alerta</span>
            </div>
            <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <!-- Alertas Críticas Solamente -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                <div>
                    <p class="text-white font-medium text-sm">Alertas Críticas Solamente</p>
                    <p class="text-gray-400 text-xs mt-0.5">Ignorar notificaciones informativas o de bajo nivel.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="critical_only" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-moon"></i> Horario Silencioso
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>Nunca</option>
                        <option>22:00 - 06:00</option>
                        <option>Fines de Semana</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-layer-group"></i> Agrupación
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>Individual</option>
                        <option selected>Resumen Diario</option>
                        <option>Resumen Semanal</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-blue-500/20 text-blue-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-filter"></i> Filtrado
                </span>
                <span class="text-xs text-gray-500">Inteligente</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Guardar Reglas
            </button>
        </div>
    </div>
</div>
