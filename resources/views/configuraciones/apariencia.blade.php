<div class="space-y-6">
    <!-- Personalización del Tema -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-palette text-rose-500"></i>
                <span class="text-white font-semibold">Personalización del Tema</span>
            </div>
            <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <!-- Tema Oscuro True Black -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                <div>
                    <p class="text-white font-medium text-sm">Tema Oscuro "True Black"</p>
                    <p class="text-gray-400 text-xs mt-0.5">Utilizar fondo negro absoluto para pantallas OLED.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="true_black" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-font"></i> Fuente del Sistema
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>Outfit (Recomendado)</option>
                        <option>Inter</option>
                        <option>Roboto</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-magic"></i> Intensidad de Neón
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>Sutil</option>
                        <option selected>Intenso</option>
                        <option>Apagado</option>
                    </select>
                </div>
            </div>

            <!-- Efectos de Transparencia -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10 mt-4">
                <div>
                    <p class="text-white font-medium text-sm">Efectos de Transparencia</p>
                    <p class="text-gray-400 text-xs mt-0.5">Habilitar efecto de vidrio molido en tarjetas (Glassmorphism).</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="glass_effect" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-green-500/20 text-green-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-eye"></i> Visualización
                </span>
                <span class="text-xs text-gray-500">High Contrast</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Guardar Apariencia
            </button>
        </div>
    </div>

    <!-- Experiencia de Usuario (UX) -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-desktop text-rose-500"></i>
                <span class="text-white font-semibold">Experiencia de Usuario (UX)</span>
            </div>
            <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <!-- Animaciones de Interfaz -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                <div>
                    <p class="text-white font-medium text-sm">Animaciones de Interfaz</p>
                    <p class="text-gray-400 text-xs mt-0.5">Suavizar transiciones entre páginas y elementos.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="animations" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-compress-arrows-alt"></i> Densidad de Contenido
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>Compacto</option>
                        <option selected>Confortable</option>
                        <option>Amplio</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-columns"></i> Sidebar Inicial
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>Expandido</option>
                        <option>Colapsado</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-green-500/20 text-green-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-bolt"></i> Rendimiento
                </span>
                <span class="text-xs text-gray-500">60 FPS</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Guardar Preferencias
            </button>
        </div>
    </div>
</div>
