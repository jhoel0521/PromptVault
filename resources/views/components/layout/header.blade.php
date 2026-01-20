{{-- Header - Tailwind + Alpine --}}
<header
    class="sticky top-4 z-30 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm px-6 py-4 flex items-center justify-between"
    x-data="{ open: null }" @click.outside="open = null">
    <!-- Left: Brand + Search -->
    <div class="flex items-center gap-6 flex-1 min-w-0">
        <a href="{{ route('dashboard') }}"
            class="text-lg font-bold text-slate-900 dark:text-white whitespace-nowrap">PromptVault</a>
        <form action="{{ route('buscador.index') }}" method="GET" class="relative flex-1 max-w-xl">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-red-600" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" />
                <path d="M21 21l-4.35-4.35" />
            </svg>
            <input name="query" type="text" placeholder="Buscar prompts..."
                class="w-full pl-10 pr-3 py-2 text-sm rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-100 focus:border-red-600 focus:ring-0" />
        </form>
    </div>

    <!-- Right actions -->
    <div class="flex items-center gap-3 ml-4">
        @auth
            <!-- Quick action: crear prompt -->
            <a href="{{ route('prompts.create') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                <span>Nuevo Prompt</span>
            </a>

            <!-- Notificaciones -->
            <button class="relative p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800"
                @click="open = open === 'notif' ? null : 'notif'">
                <svg class="w-5 h-5 text-slate-700 dark:text-slate-200" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
                <span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-red-600 rounded-full"></span>
            </button>

            <!-- Perfil -->
            <div class="relative">
                <button class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800"
                    @click="open = open === 'profile' ? null : 'profile'">
                    <img src="{{ Auth::user()->avatar_url ?? asset('images/default-avatar.png') }}" alt="Avatar"
                        class="w-8 h-8 rounded-full object-cover">
                    <span
                        class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate max-w-[120px]">{{ Auth::user()->name ?? 'Usuario' }}</span>
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>

                <div x-show="open === 'profile'" x-transition
                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg overflow-hidden z-50">
                    <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-700">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">
                            {{ Auth::user()->name ?? 'Usuario' }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                    <div class="flex flex-col py-1">
                        <a href="{{ route('profile.edit') }}"
                            class="px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">Mi
                            perfil</a>
                        @if (Route::has('profile.security'))
                            <a href="#"
                                class="px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">Seguridad</a>
                        @endif
                    </div>
                    <div class="border-t border-slate-200 dark:border-slate-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30">Cerrar
                                sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}"
                class="px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-200 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">Iniciar
                sesión</a>
            <a href="{{ route('register') }}"
                class="px-3 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">Registrarse</a>
        @endauth
    </div>
</header>
