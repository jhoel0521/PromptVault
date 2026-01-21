<x-app-layout>
    <x-slot:header>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-tr from-rose-500 to-blue-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-cogs text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white">Panel de Configuración</h1>
                <p class="text-sm text-gray-400">Gestiona las opciones y parámetros del sistema</p>
            </div>
        </div>
    </x-slot:header>

    <!-- Stats Toolbar -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-4 mb-6">
        <div class="flex flex-wrap items-center gap-4 text-sm">
            <div class="flex items-center gap-2">
                <i class="fas fa-code-branch text-rose-500"></i>
                <span class="text-white">v2.5.0</span>
            </div>
            <div class="w-px h-4 bg-white/20"></div>
            <div class="flex items-center gap-2">
                <i class="fab fa-php text-blue-500"></i>
                <span class="text-white">{{ phpversion() }}</span>
            </div>
            <div class="w-px h-4 bg-white/20"></div>
            <div class="flex items-center gap-2">
                <i class="fas fa-database text-yellow-500"></i>
                <span class="text-white">MySQL</span>
            </div>
            <div class="w-px h-4 bg-white/20"></div>
            <div class="flex items-center gap-2">
                <i class="fas fa-circle text-green-500 text-[8px]"></i>
                <span class="text-white">Online</span>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs + Content -->
    <div class="space-y-6">
        <!-- Tabs -->
        <div class="flex flex-wrap gap-3 overflow-x-auto pb-2">
            <a href="{{ route('admin.configuraciones.general') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg border transition-all duration-200 {{ request()->routeIs('admin.configuraciones.general') ? 'bg-rose-500 border-rose-500' : 'bg-white/5 border-white/10 hover:bg-white/10' }}">
                <i class="fas fa-sliders-h {{ request()->routeIs('admin.configuraciones.general') ? 'text-white' : 'text-gray-400' }}"></i>
                <div class="text-left">
                    <div class="text-[10px] uppercase tracking-wider {{ request()->routeIs('admin.configuraciones.general') ? 'text-rose-200' : 'text-gray-500' }}">CONFIGURACIÓN</div>
                    <div class="text-sm font-medium {{ request()->routeIs('admin.configuraciones.general') ? 'text-white' : 'text-gray-300' }}">General</div>
                </div>
            </a>
            
            <a href="{{ route('admin.configuraciones.seguridad') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg border transition-all duration-200 {{ request()->routeIs('admin.configuraciones.seguridad') ? 'bg-rose-500 border-rose-500' : 'bg-white/5 border-white/10 hover:bg-white/10' }}">
                <i class="fas fa-shield-alt {{ request()->routeIs('admin.configuraciones.seguridad') ? 'text-white' : 'text-gray-400' }}"></i>
                <div class="text-left">
                    <div class="text-[10px] uppercase tracking-wider {{ request()->routeIs('admin.configuraciones.seguridad') ? 'text-rose-200' : 'text-gray-500' }}">CONFIGURACIÓN</div>
                    <div class="text-sm font-medium {{ request()->routeIs('admin.configuraciones.seguridad') ? 'text-white' : 'text-gray-300' }}">Seguridad</div>
                </div>
            </a>

            <a href="{{ route('admin.configuraciones.apariencia') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg border transition-all duration-200 {{ request()->routeIs('admin.configuraciones.apariencia') ? 'bg-rose-500 border-rose-500' : 'bg-white/5 border-white/10 hover:bg-white/10' }}">
                <i class="fas fa-paint-brush {{ request()->routeIs('admin.configuraciones.apariencia') ? 'text-white' : 'text-gray-400' }}"></i>
                <div class="text-left">
                    <div class="text-[10px] uppercase tracking-wider {{ request()->routeIs('admin.configuraciones.apariencia') ? 'text-rose-200' : 'text-gray-500' }}">CONFIGURACIÓN</div>
                    <div class="text-sm font-medium {{ request()->routeIs('admin.configuraciones.apariencia') ? 'text-white' : 'text-gray-300' }}">Apariencia</div>
                </div>
            </a>
            
            <a href="{{ route('admin.configuraciones.notificaciones') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg border transition-all duration-200 {{ request()->routeIs('admin.configuraciones.notificaciones') ? 'bg-rose-500 border-rose-500' : 'bg-white/5 border-white/10 hover:bg-white/10' }}">
                <i class="fas fa-bell {{ request()->routeIs('admin.configuraciones.notificaciones') ? 'text-white' : 'text-gray-400' }}"></i>
                <div class="text-left">
                    <div class="text-[10px] uppercase tracking-wider {{ request()->routeIs('admin.configuraciones.notificaciones') ? 'text-rose-200' : 'text-gray-500' }}">CONFIGURACIÓN</div>
                    <div class="text-sm font-medium {{ request()->routeIs('admin.configuraciones.notificaciones') ? 'text-white' : 'text-gray-300' }}">Notificaciones</div>
                </div>
            </a>

            <a href="{{ route('admin.configuraciones.respaldos') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg border transition-all duration-200 {{ request()->routeIs('admin.configuraciones.respaldos') ? 'bg-rose-500 border-rose-500' : 'bg-white/5 border-white/10 hover:bg-white/10' }}">
                <i class="fas fa-database {{ request()->routeIs('admin.configuraciones.respaldos') ? 'text-white' : 'text-gray-400' }}"></i>
                <div class="text-left">
                    <div class="text-[10px] uppercase tracking-wider {{ request()->routeIs('admin.configuraciones.respaldos') ? 'text-rose-200' : 'text-gray-500' }}">CONFIGURACIÓN</div>
                    <div class="text-sm font-medium {{ request()->routeIs('admin.configuraciones.respaldos') ? 'text-white' : 'text-gray-300' }}">Respaldos</div>
                </div>
            </a>

            <a href="{{ route('admin.configuraciones.sistema') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg border transition-all duration-200 {{ request()->routeIs('admin.configuraciones.sistema') ? 'bg-rose-500 border-rose-500' : 'bg-white/5 border-white/10 hover:bg-white/10' }}">
                <i class="fas fa-server {{ request()->routeIs('admin.configuraciones.sistema') ? 'text-white' : 'text-gray-400' }}"></i>
                <div class="text-left">
                    <div class="text-[10px] uppercase tracking-wider {{ request()->routeIs('admin.configuraciones.sistema') ? 'text-rose-200' : 'text-gray-500' }}">CONFIGURACIÓN</div>
                    <div class="text-sm font-medium {{ request()->routeIs('admin.configuraciones.sistema') ? 'text-white' : 'text-gray-300' }}">Sistema</div>
                </div>
            </a>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- LEFT COLUMN (Sidebar) -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Help Center Card -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
                    <div class="w-20 h-20 bg-gradient-to-tr from-gray-800 to-gray-700 rounded-full flex items-center justify-center mb-4 mx-auto border-2 border-rose-500 shadow-lg shadow-rose-500/30">
                        <i class="fas fa-life-ring text-rose-500 text-3xl"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white text-center mb-1">Centro de Soporte</h2>
                    <p class="text-sm text-gray-400 text-center mb-6">Recursos & Ayuda</p>

                    <!-- Help Tip -->
                    <div class="bg-white/5 border-l-4 border-rose-500 rounded-lg p-4 mb-4">
                        <h4 class="text-white text-sm font-semibold mb-2 flex items-center gap-2">
                            <i class="fas fa-book text-rose-500"></i> Documentación
                        </h4>
                        <p class="text-xs text-gray-400 leading-relaxed mb-2">
                            Guía completa para administradores del sistema.
                        </p>
                        <a href="#" class="text-xs text-rose-500 hover:text-rose-400 flex items-center gap-1">
                            Ver Manual <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-2">
                        <button class="flex items-center justify-center gap-2 px-3 py-2 bg-rose-500/10 border border-rose-500/30 text-rose-500 text-xs rounded-lg hover:bg-rose-500/20 transition-colors">
                            <i class="fas fa-bug"></i> Reportar
                        </button>
                        <button class="flex items-center justify-center gap-2 px-3 py-2 bg-rose-500 text-white text-xs rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30">
                            <i class="fas fa-headset"></i> Chat
                        </button>
                    </div>
                </div>

                <!-- Server Status Card -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4 pb-2 border-b border-white/10">
                        <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-server text-rose-500"></i> Estado del Servidor
                        </h3>
                        <span class="px-2 py-1 bg-green-500/20 text-green-500 text-[10px] rounded-full flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Óptimo
                        </span>
                    </div>

                    <!-- Resources -->
                    <div class="space-y-4">
                        <!-- CPU -->
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-gray-400 flex items-center gap-1.5">
                                    <i class="fas fa-microchip"></i> CPU
                                </span>
                                <span class="text-white">12%</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-rose-500 shadow-lg shadow-rose-500/50" style="width: 12%"></div>
                            </div>
                        </div>

                        <!-- RAM -->
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-gray-400 flex items-center gap-1.5">
                                    <i class="fas fa-memory"></i> RAM
                                </span>
                                <span class="text-white">2.1 GB / 4 GB</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500" style="width: 55%"></div>
                            </div>
                        </div>

                        <!-- Storage -->
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-gray-400 flex items-center gap-1.5">
                                    <i class="fas fa-hdd"></i> Almacenamiento
                                </span>
                                <span class="text-white">120 GB Libres</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-green-500" style="width: 28%"></div>
                            </div>
                        </div>

                        <!-- Footer Stats -->
                        <div class="pt-3 border-t border-white/5 flex items-center justify-between text-[10px] text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-network-wired"></i> Latencia: 24ms
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-clock"></i> Uptime: 3d 4h
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN (Settings Content) -->
            <div class="lg:col-span-3">
                <!-- GENERAL -->
                <div x-show="activeTab === 'general'" x-transition>
                    @include('configuraciones.general')
                </div>

                <!-- SECURITY -->
                <div x-show="activeTab === 'security'" x-transition x-cloak>
                    @include('configuraciones.seguridad')
                </div>

                <!-- APPEARANCE -->
                <div x-show="activeTab === 'appearance'" x-transition x-cloak>
                    @include('configuraciones.apariencia')
                </div>

                <!-- NOTIFICATIONS -->
                <div x-show="activeTab === 'notifications'" x-transition x-cloak>
                    @include('configuraciones.notificaciones')
                </div>

                <!-- BACKUPS -->
                <div x-show="activeTab === 'backups'" x-transition x-cloak>
                    @include('configuraciones.respaldos')
                </div>
                
                <!-- SYSTEM -->
                <div x-show="activeTab === 'system'" x-transition x-cloak>
                    @include('configuraciones.sistema')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
