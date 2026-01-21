<x-app-layout>
    <x-slot:header>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.reportes.index') }}" 
                   class="w-10 h-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left text-slate-600 dark:text-slate-300"></i>
                </a>
                <div class="w-12 h-12 bg-gradient-to-tr from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-lightbulb text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Análisis de Prompts</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Estadísticas detalladas de prompts y su uso</p>
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
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-lightbulb text-purple-600 dark:text-purple-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalPrompts ?? 0 }}</h3>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Total Prompts</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tags text-blue-600 dark:text-blue-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalEtiquetas ?? 0 }}</h3>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Etiquetas Únicas</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-code-branch text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalVersiones ?? 0 }}</h3>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Versiones Creadas</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-share-alt text-amber-600 dark:text-amber-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalCompartidos ?? 0 }}</h3>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Prompts Compartidos</p>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Prompts por Mes -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Prompts Creados por Mes</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Últimos 6 meses</p>
                </div>
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-purple-600 dark:text-purple-400"></i>
                </div>
            </div>
            <canvas id="promptsPorMes" class="w-full" style="max-height: 300px;"></canvas>
        </div>

        <!-- Prompts por Etiqueta -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Top 10 Etiquetas</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Más utilizadas</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tags text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <canvas id="promptsPorEtiqueta" class="w-full" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Versiones por Prompt -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Distribución de Versiones</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Prompts con más versiones</p>
                </div>
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-code-branch text-green-600 dark:text-green-400"></i>
                </div>
            </div>
            <canvas id="versionesPorPrompt" class="w-full" style="max-height: 300px;"></canvas>
        </div>

        <!-- Privados vs Compartidos -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Privados vs Compartidos</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Distribución de visibilidad</p>
                </div>
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-share-alt text-amber-600 dark:text-amber-400"></i>
                </div>
            </div>
            <canvas id="promptsVisibilidad" class="w-full" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <!-- Top Prompts Table -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Top 10 Prompts Más Activos</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">Por número de versiones y ediciones</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                <i class="fas fa-trophy text-purple-600 dark:text-purple-400"></i>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-600 dark:text-slate-400 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-600 dark:text-slate-400 uppercase">Título</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-600 dark:text-slate-400 uppercase">Usuario</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-slate-600 dark:text-slate-400 uppercase">Versiones</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-slate-600 dark:text-slate-400 uppercase">Compartido</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-600 dark:text-slate-400 uppercase">Última Edición</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($topPrompts ?? [] as $index => $prompt)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-4 py-3 text-sm text-slate-900 dark:text-white font-medium">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('prompts.show', $prompt->id) }}" class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline">
                                {{ Str::limit($prompt->titulo, 50) }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">
                            {{ $prompt->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-medium rounded-full">
                                {{ $prompt->versiones_count ?? 0 }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($prompt->visibilidad === 'publico')
                                <i class="fas fa-check-circle text-green-500"></i>
                            @else
                                <i class="fas fa-lock text-slate-400"></i>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">
                            {{ $prompt->updated_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p>No hay datos disponibles</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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

        // 1. Prompts por Mes (Line Chart)
        new Chart(document.getElementById('promptsPorMes'), {
            type: 'line',
            data: {
                labels: {!! json_encode($chartMeses ?? ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun']) !!},
                datasets: [{
                    label: 'Prompts Creados',
                    data: {!! json_encode($chartPromptsData ?? [5, 12, 18, 15, 22, 28]) !!},
                    borderColor: '#a855f7',
                    backgroundColor: 'rgba(168, 85, 247, 0.1)',
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

        // 2. Prompts por Etiqueta (Bar Chart)
        new Chart(document.getElementById('promptsPorEtiqueta'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartEtiquetasLabels ?? ['Marketing', 'Código', 'Diseño', 'SEO', 'Social', 'Email', 'Blog', 'Video', 'Análisis', 'Otro']) !!},
                datasets: [{
                    label: 'Prompts',
                    data: {!! json_encode($chartEtiquetasData ?? [25, 18, 15, 12, 10, 8, 6, 5, 4, 3]) !!},
                    backgroundColor: '#3b82f6'
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

        // 3. Versiones por Prompt (Bar Chart Horizontal)
        new Chart(document.getElementById('versionesPorPrompt'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartVersionesLabels ?? ['Prompt A', 'Prompt B', 'Prompt C', 'Prompt D', 'Prompt E']) !!},
                datasets: [{
                    label: 'Versiones',
                    data: {!! json_encode($chartVersionesData ?? [12, 8, 6, 5, 4]) !!},
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { beginAtZero: true }
                }
            }
        });

        // 4. Privados vs Compartidos (Doughnut Chart)
        new Chart(document.getElementById('promptsVisibilidad'), {
            type: 'doughnut',
            data: {
                labels: ['Privados', 'Compartidos'],
                datasets: [{
                    data: {!! json_encode($chartVisibilidadData ?? [60, 40]) !!},
                    backgroundColor: ['#64748b', '#f59e0b']
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
    </script>
</x-app-layout>
