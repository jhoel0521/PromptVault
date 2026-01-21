<x-app-layout>
    <x-slot:header>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-tr from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-pie text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Centro de Reportes</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Estadísticas y análisis de PromptVault</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="window.print()" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg transition-colors">
                    <i class="fas fa-print"></i>
                    <span>Imprimir</span>
                </button>
            </div>
        </div>
    </x-slot:header>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Prompts -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-lightbulb text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <span class="text-xs font-medium px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full">
                    +12% mes
                </span>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalPrompts ?? 0 }}</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400">Total Prompts</p>
        </div>

        <!-- Total Eventos -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <span class="text-xs font-medium px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full">
                    +8% mes
                </span>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalEventos ?? 0 }}</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400">Total Eventos</p>
        </div>

        <!-- Total Usuarios -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <span class="text-xs font-medium px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full">
                    +5% mes
                </span>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalUsuarios ?? 0 }}</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400">Usuarios Activos</p>
        </div>

        <!-- Compartidos -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-share-alt text-amber-600 dark:text-amber-400 text-xl"></i>
                </div>
                <span class="text-xs font-medium px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-full">
                    +18% mes
                </span>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-1">{{ $totalCompartidos ?? 0 }}</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400">Prompts Compartidos</p>
        </div>
    </div>

    <!-- Report Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Reporte de Prompts -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-lightbulb text-white text-2xl"></i>
                    </div>
                    <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-medium rounded-full">
                        Disponible
                    </span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Análisis de Prompts</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    Estadísticas de creación, edición, versiones, etiquetas y prompts más populares.
                </p>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.reportes.prompts') }}" 
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-500 hover:from-purple-700 hover:to-purple-600 text-white font-medium rounded-lg shadow-sm transition-all">
                        <span>Ver Reporte</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Reporte de Calendario -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-full">
                        Disponible
                    </span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Análisis de Eventos</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    Distribución temporal, eventos por tipo, completados vs pendientes y productividad.
                </p>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.reportes.eventos') }}" 
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-medium rounded-lg shadow-sm transition-all">
                        <span>Ver Reporte</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Reporte de Usuarios -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-medium rounded-full">
                        Disponible
                    </span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Actividad de Usuarios</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    Usuarios más activos, distribución por roles, sesiones y actividad mensual.
                </p>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.usuarios.index') }}" 
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-medium rounded-lg shadow-sm transition-all">
                        <span>Ver Reporte</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Reporte de AI Provider -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-robot text-white text-2xl"></i>
                    </div>
                    <span class="px-2 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-xs font-medium rounded-full">
                        Disponible
                    </span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Uso de AI (Groq)</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    Prompts generados con IA, tokens consumidos y estadísticas de uso del chatbot.
                </p>
                <div class="flex items-center gap-2">
                    <button type="button" 
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium rounded-lg cursor-not-allowed opacity-60">
                        <span>Próximamente</span>
                        <i class="fas fa-lock"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Reporte de Compartidos -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-share-alt text-white text-2xl"></i>
                    </div>
                    <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-xs font-medium rounded-full">
                        Disponible
                    </span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Prompts Compartidos</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    Análisis de compartición, accesos, permisos y colaboración entre usuarios.
                </p>
                <div class="flex items-center gap-2">
                    <button type="button" 
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium rounded-lg cursor-not-allowed opacity-60">
                        <span>Próximamente</span>
                        <i class="fas fa-lock"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Reporte de Sistema -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-slate-500 to-slate-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-server text-white text-2xl"></i>
                    </div>
                    <span class="px-2 py-1 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-medium rounded-full">
                        Disponible
                    </span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Estado del Sistema</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    Almacenamiento, rendimiento, logs de actividad y health check del sistema.
                </p>
                <div class="flex items-center gap-2">
                    <button type="button" 
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium rounded-lg cursor-not-allowed opacity-60">
                        <span>Próximamente</span>
                        <i class="fas fa-lock"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>