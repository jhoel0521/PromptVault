<x-app-layout>
    <x-slot:header>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.reportes.index') }}" 
                   class="w-10 h-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left text-slate-600 dark:text-slate-300"></i>
                </a>
                <div class="w-12 h-12 bg-gradient-to-tr from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Análisis de Eventos</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Estadísticas del calendario y productividad</p>
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

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-600 dark:text-blue-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalEventos ?? 0 }}</h3>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Total Eventos</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $eventosCompletados ?? 0 }}</h3>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Completados</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-amber-600 dark:text-amber-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $eventosPendientes ?? 0 }}</h3>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Pendientes</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-percentage text-purple-600 dark:text-purple-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $tasaCompletado ?? 0 }}%</h3>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Tasa de Completado</p>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Eventos por Mes -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Eventos por Mes</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Últimos 6 meses</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <canvas id="eventosPorMes" class="w-full" style="max-height: 300px;"></canvas>
        </div>

        <!-- Eventos por Tipo -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Eventos por Tipo</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Distribución</p>
                </div>
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-pie text-purple-600 dark:text-purple-400"></i>
                </div>
            </div>
            <canvas id="eventosPorTipo" class="w-full" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Completados vs Pendientes -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Estado de Eventos</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Completados vs Pendientes</p>
                </div>
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tasks text-green-600 dark:text-green-400"></i>
                </div>
            </div>
            <canvas id="eventosEstado" class="w-full" style="max-height: 300px;"></canvas>
        </div>

        <!-- Eventos por Día de la Semana -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Eventos por Día</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Distribución semanal</p>
                </div>
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-week text-amber-600 dark:text-amber-400"></i>
                </div>
            </div>
            <canvas id="eventosPorDia" class="w-full" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        // Configuración global Chart.js para dark mode
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#cbd5e1' : '#475569';
        const gridColor = isDark ? '#334155' : '#e2e8f0';

        Chart.defaults.color = textColor;
        Chart.defaults.borderColor = gridColor;

        // 1. Eventos por Mes (Line Chart)
        new Chart(document.getElementById('eventosPorMes'), {
            type: 'line',
            data: {
                labels: {!! json_encode($chartMeses ?? ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun']) !!},
                datasets: [{
                    label: 'Eventos Creados',
                    data: {!! json_encode($chartEventosData ?? [8, 15, 12, 18, 20, 16]) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // 2. Eventos por Tipo (Doughnut Chart)
        new Chart(document.getElementById('eventosPorTipo'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($chartTiposLabels ?? ['Reunión', 'Tarea', 'Evento', 'Recordatorio']) !!},
                datasets: [{
                    data: {!! json_encode($chartTiposData ?? [35, 28, 22, 15]) !!},
                    backgroundColor: ['#a855f7', '#3b82f6', '#10b981', '#f59e0b']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // 3. Completados vs Pendientes (Bar Chart)
        new Chart(document.getElementById('eventosEstado'), {
            type: 'bar',
            data: {
                labels: ['Completados', 'Pendientes'],
                datasets: [{
                    label: 'Eventos',
                    data: {!! json_encode($chartEstadoData ?? [65, 35]) !!},
                    backgroundColor: ['#10b981', '#f59e0b']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // 4. Eventos por Día de la Semana (Radar Chart)
        new Chart(document.getElementById('eventosPorDia'), {
            type: 'radar',
            data: {
                labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Eventos',
                    data: {!! json_encode($chartDiasData ?? [12, 15, 10, 18, 14, 6, 4]) !!},
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.2)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    r: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
