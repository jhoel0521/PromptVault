<div class="space-y-6">
    <!-- Estrategia de Respaldo -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-database text-rose-500"></i>
                <span class="text-white font-semibold">Estrategia de Respaldo</span>
            </div>
            <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <!-- Respaldos Automáticos -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                <div>
                    <p class="text-white font-medium text-sm">Respaldos Automáticos</p>
                    <p class="text-gray-400 text-xs mt-0.5">Generar copias de la base de datos sin intervención manual.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="auto_backup" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-clock"></i> Frecuencia
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>Cada 6 Horas</option>
                        <option selected>Diario (00:00)</option>
                        <option>Semanal (Domingo)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-history"></i> Retención Local
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>Últimos 7 días</option>
                        <option>Últimos 30 días</option>
                        <option>Indefinido</option>
                    </select>
                </div>
            </div>

            <!-- Incluir Archivos Multimedia -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10 mt-4">
                <div>
                    <p class="text-white font-medium text-sm">Incluir Archivos Multimedia</p>
                    <p class="text-gray-400 text-xs mt-0.5">Respaldar imágenes y documentos subidos (aumenta el tamaño).</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="include_media" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-green-500/20 text-green-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-calendar-check"></i> Programado
                </span>
                <span class="text-xs text-gray-500">Próximo: 00:00</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-save"></i> Guardar Estrategia
            </button>
        </div>
    </div>

    <!-- Almacenamiento en la Nube -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-cloud-upload-alt text-rose-500"></i>
                <span class="text-white font-semibold">Almacenamiento en la Nube</span>
            </div>
            <button class="px-4 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <!-- Sincronización Cloud -->
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/10">
                <div>
                    <p class="text-white font-medium text-sm">Sincronización Cloud</p>
                    <p class="text-gray-400 text-xs mt-0.5">Subir copias automáticamente a un proveedor externo.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="cloud_sync" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-500"></div>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-server"></i> Proveedor
                    </label>
                    <select class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                        <option>Amazon S3</option>
                        <option>Google Drive</option>
                        <option>Dropbox</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-folder-open"></i> Ruta Remota
                    </label>
                    <input type="text" value="/backups/tech-home/" class="w-full px-4 py-2.5 bg-black/30 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-colors">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-green-500/20 text-green-500 text-xs rounded-full flex items-center gap-1.5">
                    <i class="fas fa-link"></i> Conectado
                </span>
                <span class="text-xs text-gray-500">API OK</span>
            </div>
            <button class="px-5 py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30 flex items-center gap-2">
                <i class="fas fa-bolt"></i> Ejecutar Backup Ahora
            </button>
        </div>
    </div>
</div>
