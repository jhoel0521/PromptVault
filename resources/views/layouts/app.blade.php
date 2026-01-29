@props([
    'title' => 'PromptVault',
])
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Pre-carga: asegura que la clase dark se aplique antes de pintar para evitar flicker
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
    @stack('styles')
</head>

<body class="min-h-screen bg-gradient-to-br from-[#450a0a] to-[#7f1d1d] font-['Montserrat']" 
    x-data="themeToggle()" 
      @theme-toggle.window="toggleTheme()">
    <div class="flex min-h-screen w-full gap-6 p-6 items-start">
        <x-layout.sidebar />
        <div class="flex flex-col flex-1 w-full min-w-0 gap-8">
            <x-layout.header />
            <main class="flex-1 w-full p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-3xl shadow-md text-slate-900 dark:text-slate-100">
                {{ $slot }}
            </main>
            <x-layout.footer />
        </div>
    </div>
    <x-layout.loading />
    @stack('scripts')
</body>

</html>
