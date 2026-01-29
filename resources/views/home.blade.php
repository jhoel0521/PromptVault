<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PromptVault - Biblioteca de Prompts</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (() => {
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const initial = stored || (prefersDark ? 'dark' : 'light');
            if (initial === 'dark') {
                document.documentElement.classList.add('dark');
                if (document.body) {
                    document.body.classList.add('dark');
                }
            }
        })();

        function themeToggle() {
            return {
                darkMode: localStorage.getItem('theme') !== 'light',
                toggleTheme() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                    document.documentElement.classList.toggle('dark', this.darkMode);
                    document.body.classList.toggle('dark', this.darkMode);
                }
            }
        }
    </script>
</head>
<body x-data="themeToggle()" 
      :class="darkMode ? 'dark' : ''" 
      class="min-h-screen font-['Montserrat']"
      x-bind:style="darkMode ? 'background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%)' : 'background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%)'">
    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 backdrop-blur-sm border-b" :class="darkMode ? 'bg-slate-900 border-slate-700' : 'bg-white border-slate-200'">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold text-rose-600 hover:text-rose-500 transition">
                    <i class="fas fa-bolt"></i>
                    <span>PromptVault</span>
                </a>
                
                <div class="flex items-center gap-4">
                    <button @click="toggleTheme()"
                        class="p-2 rounded-lg transition"
                        :class="darkMode ? 'text-slate-300 hover:text-slate-100 hover:bg-slate-800' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'">
                        <i class="fas fa-moon text-lg" x-show="darkMode"></i>
                        <i class="fas fa-sun text-lg" x-show="!darkMode" style="display:none;"></i>
                    </button>
                    
                    @auth
                        <a href="{{ route('prompts.index') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition"
                           :class="darkMode ? 'text-slate-300 hover:text-slate-100 hover:bg-slate-800' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'">
                            <i class="fas fa-folder"></i> Mis Prompts
                        </a>
                        <a href="{{ route('perfil.index') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition"
                           :class="darkMode ? 'text-slate-300 hover:text-slate-100 hover:bg-slate-800' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'">
                            <i class="fas fa-user"></i> Perfil
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold bg-rose-600 text-white hover:bg-rose-700 transition">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-semibold bg-rose-600 text-white hover:bg-rose-700 transition">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <main class="max-w-7xl mx-auto px-6 py-12">
        {{-- Hero --}}
        <section class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl font-bold mb-4" 
                :class="darkMode ? 'bg-gradient-to-r from-white to-rose-600' : 'bg-gradient-to-r from-slate-900 to-rose-600'"
                style="background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Biblioteca de
            </h1>
            <p class="text-xl" :class="darkMode ? 'text-slate-400' : 'text-slate-600'">Descubre y comparte los mejores prompts para IA</p>
        </section>
        
        {{-- Filtros --}}
        <x-prompt.filters :etiquetas="$etiquetas" :showVisibility="false" />
        
        {{-- Grid de prompts --}}
        <x-prompt.grid 
            :prompts="$prompts" 
            emptyMessage="No hay prompts públicos disponibles" 
            emptyIcon="search"
        />
    </main>

    {{-- Chatbot Widget --}}
    <x-chatbot-widget />
    
    <x-chatbot-widget />
</body>
</html>
