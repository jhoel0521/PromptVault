<div class="space-y-6">
    <!-- Información General -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-globe text-rose-500"></i>
                <span class="text-white font-semibold">Información General</span>
            </div>
            <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fas fa-signature"></i> Nombre del Sistema
                </label>
                <input type="text" value="Tech Home Books" class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fas fa-link"></i> URL Principal
                </label>
                <input type="text" value="{{ url('/') }}" readonly class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-gray-400 opacity-70">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fas fa-envelope"></i> Correo de Soporte
                </label>
                <input type="email" value="soporte@tech-home.edu.bo" class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fas fa-phone"></i> Teléfono de Contacto
                </label>
                <input type="text" value="+591 70000000" class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
            </div>

            <!-- Modo Mantenimiento -->
            <div class="col-span-full">
                <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                    <div>
                        <p class="text-white font-medium text-sm">Modo Mantenimiento</p>
                        <p class="text-gray-400 text-xs mt-0.5">Restringir acceso a usuarios no administradores.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="maintenance_mode" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-green-500/20 text-green-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-check-circle"></i> Sincronizado
                </span>
                <span class="text-xs text-gray-500">Habilitado</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </div>

    <!-- Gestión Académica -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-university text-rose-500"></i>
                <span class="text-white font-semibold">Gestión Académica</span>
            </div>
            <div class="flex items-center gap-2">
                <button class="px-4 py-2 bg-rose-500/20 border border-rose-500/50 text-rose-500 text-xs rounded-lg hover:bg-rose-500/30 transition-colors flex items-center gap-2">
                    <i class="fas fa-file-alt"></i> Reporte
                </button>
                <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                    <i class="fas fa-sync-alt"></i> Reset
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i> Periodo Actual
                </label>
                <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                    <option>2025 - Gestión I</option>
                    <option>2025 - Gestión II</option>
                    <option>Verano</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fas fa-users"></i> Capacidad Cursos
                </label>
                <input type="number" value="40" class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
            </div>

            <!-- Registro Público -->
            <div class="col-span-full">
                <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                    <div>
                        <p class="text-white font-medium text-sm">Registro Público</p>
                        <p class="text-gray-400 text-xs mt-0.5">Nuevos estudiantes pueden registrarse libremente.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="student_registration" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-blue-500/20 text-blue-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-graduation-cap"></i> Académico
                </span>
                <span class="text-xs text-gray-500">Activo</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </div>
</div>
