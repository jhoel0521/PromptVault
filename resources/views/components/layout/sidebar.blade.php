{{-- Sidebar - Tailwind + Alpine --}}
@php
    $user = Auth::user();
    $role = $user->role->nombre ?? 'guest';
    $promptsCount = $user?->prompts()->count() ?? 0;
@endphp

<aside
    class="w-64 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm flex flex-col sticky top-4 h-[calc(100vh-2rem)]"
    x-data="{ open: { collab: false, admin: false, user: false } }">
    <div class="px-4 py-3 border-b border-slate-200 dark:border-slate-700">
        <a href="{{ route('home') }}" class="flex items-center gap-3 no-underline">
            <div class="w-10 h-10 bg-white dark:bg-slate-800 rounded-lg flex items-center justify-center shadow">
                <img src="{{ asset('images/LogoLoginPrompt.png') }}" alt="PromptVault" class="w-6 h-6 object-contain">
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-bold text-slate-900 dark:text-white">PromptVault</span>
                <span class="text-xs text-slate-500 dark:text-slate-400 capitalize">{{ $role }}</span>
            </div>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto px-2 py-3 space-y-3">
        <div class="space-y-1">
            <p class="px-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Biblioteca</p>
            <a href="{{ route('prompts.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('prompts.index') ? 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-200' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                </svg>
                <span class="flex-1">Prompts</span>
                <span
                    class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-100 dark:bg-red-900/30 text-xs font-bold text-red-700 dark:text-red-200">{{ $promptsCount }}</span>
            </a>
            <a href="{{ route('prompts.create') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                <span>Crear Prompt</span>
            </a>
            <a href="{{ route('calendario.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('calendario.*') ? 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-200' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                <span>Calendario</span>
            </a>
        </div>

        <div class="space-y-1">
            <button
                class="w-full px-3 py-2 flex items-center justify-between text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white"
                @click="open.collab = !open.collab">
                <span>Colaboración</span>
                <svg class="w-4 h-4" :class="{ 'rotate-180': open.collab }" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="open.collab" x-transition class="space-y-1">
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="18" cy="5" r="3" />
                        <circle cx="6" cy="12" r="3" />
                        <circle cx="18" cy="19" r="3" />
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" />
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" />
                    </svg>
                    <span class="flex-1">Compartidos</span>
                </a>
            </div>
        </div>

        @if ($role === 'admin')
            <div class="space-y-1">
                <button
                    class="w-full px-3 py-2 flex items-center justify-between text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white"
                    @click="open.admin = !open.admin">
                    <span>Sistema</span>
                    <svg class="w-4 h-4" :class="{ 'rotate-180': open.admin }" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="open.admin" x-transition class="space-y-1">
                    <a href="{{ route('admin.configuraciones.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.configuraciones.*') ? 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-200' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="flex-1">Configuraciones</span>
                    </a>
                    <a href="{{ route('admin.usuarios.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.usuarios.*') ? 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-200' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                        <span class="flex-1">Usuarios</span>
                    </a>
                    <a href="{{ route('admin.roles.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 {{ request()->routeIs('admin.roles.*') ? 'bg-slate-100 dark:bg-slate-800' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        <span class="flex-1">Roles</span>
                    </a>
                    <a href="{{ route('admin.permisos.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 {{ request()->routeIs('admin.permisos.*') ? 'bg-slate-100 dark:bg-slate-800' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        <span class="flex-1">Permisos</span>
                    </a>
                </div>
            </div>
        @endif

        <div class="space-y-1">
            <button
                class="w-full px-3 py-2 flex items-center justify-between text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white"
                @click="open.user = !open.user">
                <span>Cuenta</span>
                <svg class="w-4 h-4" :class="{ 'rotate-180': open.user }" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="open.user" x-transition class="space-y-1">
                <a href="{{ route('perfil.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <span>Mi Perfil</span>
                </a>
                @if (Route::has('profile.security'))
                    <a href="{{ route('perfil.security') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        <span>Seguridad</span>
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <div class="border-t border-slate-200 dark:border-slate-700 p-3 space-y-2">
        {{-- Toggle de Tema --}}
        <button @click="$dispatch('theme-toggle')"
            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="5" />
                <line x1="12" y1="1" x2="12" y2="3" />
                <line x1="12" y1="21" x2="12" y2="23" />
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                <line x1="1" y1="12" x2="3" y2="12" />
                <line x1="21" y1="12" x2="23" y2="12" />
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
            </svg>
            <span>Cambiar Tema</span>
        </button>

        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        @else
            <div class="space-y-2">
                <a href="{{ route('login') }}"
                    class="block text-center px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">Iniciar
                    sesión</a>
                <a href="{{ route('register') }}"
                    class="block text-center px-3 py-2 rounded-lg text-sm font-semibold text-white bg-red-600 hover:bg-red-700">Registrarse</a>
            </div>
        @endauth
    </div>
</aside>
