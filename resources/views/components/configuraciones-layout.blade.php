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

    @php
        $appVersion = config('app.version', 'v1.0.0');
        $dbDisplay = config('app.db_display', 'MySQL');
        $statusLabel = config('app.status_label', 'Online');
        $statusColor = config('app.status_color', 'green');
        $statusClass = [
            'green' => 'text-green-500',
            'yellow' => 'text-yellow-500',
            'red' => 'text-red-500',
        ][$statusColor] ?? 'text-green-500';
    @endphp

    <!-- Stats Toolbar -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-4 mb-6">
        <div class="flex flex-wrap items-center gap-4 text-sm">
            <div class="flex items-center gap-2">
                <i class="fas fa-code-branch text-rose-500"></i>
                <span class="text-white">{{ $appVersion }}</span>
            </div>
            <div class="w-px h-4 bg-white/20"></div>
            <div class="flex items-center gap-2">
                <i class="fab fa-php text-blue-500"></i>
                <span class="text-white">{{ phpversion() }}</span>
            </div>
            <div class="w-px h-4 bg-white/20"></div>
            <div class="flex items-center gap-2">
                <i class="fas fa-database text-yellow-500"></i>
                <span class="text-white">{{ $dbDisplay }}</span>
            </div>
            <div class="w-px h-4 bg-white/20"></div>
            <div class="flex items-center gap-2">
                <i class="fas fa-circle {{ $statusClass }} text-[8px]"></i>
                <span class="text-white">{{ $statusLabel }}</span>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex flex-wrap gap-3 overflow-x-auto pb-2 mb-6">
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

    <!-- Content -->
    {{ $slot }}
</x-app-layout>
