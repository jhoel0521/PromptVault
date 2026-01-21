<x-configuraciones-layout>
<div x-data="{ generating: false, downloading: false }" class="space-y-6">
    <!-- Mensajes de éxito/error -->
    @if(session('success'))
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
        <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
            <p class="text-sm text-green-800 dark:text-green-200">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-xl"></i>
            <p class="text-sm text-red-800 dark:text-red-200">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Crear Respaldo Manual -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-database text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Respaldo de Base de Datos</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Genera y descarga un archivo SQL de tu base de datos</p>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mt-0.5"></i>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-1">¿Qué incluye el respaldo?</h4>
                    <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-xs"></i>
                            <span>Todas las tablas de la base de datos</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-xs"></i>
                            <span>Estructura completa (CREATE TABLE)</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-xs"></i>
                            <span>Todos los registros (INSERT INTO)</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-times-circle text-xs"></i>
                            <span>NO incluye archivos subidos (storage/app/public)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Database Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-server text-slate-400 text-sm"></i>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Base de Datos</span>
                </div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ config('database.connections.mysql.database') }}</p>
            </div>

            <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-table text-slate-400 text-sm"></i>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Conexión</span>
                </div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ config('database.default') }}</p>
            </div>

            <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-hdd text-slate-400 text-sm"></i>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Host</span>
                </div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ config('database.connections.mysql.host') }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <form action="{{ route('admin.configuraciones.backup.create') }}" method="POST" class="space-y-4" x-ref="backupForm" @submit="generating = true">
            @csrf
            
            <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <i class="fas fa-plus-circle text-2xl text-blue-600 dark:text-blue-400"></i>
                    <div>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Generar Backup</p>
                        <p class="text-xs text-slate-600 dark:text-slate-400">Se guardará en el servidor y aparecerá en el historial</p>
                    </div>
                </div>
                <button type="submit" 
                        :disabled="generating"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 disabled:from-slate-400 disabled:to-slate-400 disabled:cursor-not-allowed text-white font-medium rounded-lg shadow-sm transition-all">
                    <template x-if="!generating">
                        <i class="fas fa-plus"></i>
                    </template>
                    <template x-if="generating">
                        <i class="fas fa-spinner fa-spin"></i>
                    </template>
                    <span x-text="generating ? 'Generando...' : 'Crear Backup'"></span>
                </button>
            </div>
        </form>
    </div>

    <!-- Historial de Respaldos -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                    <i class="fas fa-history text-slate-600 dark:text-slate-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Historial de Respaldos</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Backups almacenados en el servidor</p>
                </div>
            </div>
            @if(count($backups ?? []) > 0)
            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full">
                {{ count($backups) }} {{ count($backups) === 1 ? 'backup' : 'backups' }}
            </span>
            @endif
        </div>

        @if(count($backups ?? []) > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Nombre del Archivo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Tamaño</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Fecha</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($backups as $backup)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-file-code text-blue-500"></i>
                                <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $backup['filename'] }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-slate-600 dark:text-slate-400">{{ $backup['size_formatted'] }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-slate-600 dark:text-slate-400">{{ $backup['date_formatted'] }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.configuraciones.backup.existing', $backup['filename']) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-lg transition-colors">
                                    <i class="fas fa-download"></i>
                                    Descargar
                                </a>
                                <form action="{{ route('admin.configuraciones.backup.delete', $backup['filename']) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este backup?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-8 text-center border border-slate-200 dark:border-slate-700">
            <i class="fas fa-box-open text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
            <p class="text-sm text-slate-600 dark:text-slate-400">No hay respaldos disponibles</p>
            <p class="text-xs text-slate-500 dark:text-slate-500 mt-1">Genera tu primer backup usando el botón de arriba</p>
        </div>
        @endif
    </div>

    <!-- Recomendaciones -->
    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-6">
        <div class="flex items-start gap-3">
            <i class="fas fa-exclamation-triangle text-amber-600 dark:text-amber-400 mt-0.5"></i>
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-amber-900 dark:text-amber-100 mb-2">Recomendaciones de Seguridad</h4>
                <ul class="text-sm text-amber-800 dark:text-amber-200 space-y-1.5">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-chevron-right text-xs mt-1"></i>
                        <span>Realiza respaldos periódicos (diario, semanal según uso)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-chevron-right text-xs mt-1"></i>
                        <span>Descarga y guarda los backups en almacenamiento externo (Google Drive, Dropbox, local)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-chevron-right text-xs mt-1"></i>
                        <span>Los backups en el servidor ocupan espacio - elimina los antiguos periódicamente</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-chevron-right text-xs mt-1"></i>
                        <span>NO compartas los archivos .sql - contienen datos sensibles de la base de datos</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</x-configuraciones-layout>
