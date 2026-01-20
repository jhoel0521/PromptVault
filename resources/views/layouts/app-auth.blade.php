@props([
    'title' => 'PromptVault',
    'description' => '',
    'brandingTitle' => 'GESTIONA TUS PROMPTS CON INTELIGENCIA',
    'brandingText' =>
        'Sistema de gestión centralizada de prompts de IA con versionado automático, colaboración en tiempo real y organización inteligente por categorías y etiquetas.',
])

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - PromptVault</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $description ?: 'PromptVault - Sistema de gestión de prompts de IA' }}">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $title }} - PromptVault">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- TailwindCSS + Alpine (vía app.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $styles ?? '' }}
</head>

<body
    class="min-h-screen bg-gradient-to-br from-red-950 via-red-900 to-red-950 font-['Inter'] text-white overflow-x-hidden"
    x-data="{ loading: false }">

    <!-- Animated Background -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <!-- Gradient Shapes -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-rose-600/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute top-1/2 right-0 w-96 h-96 bg-red-700/20 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 2s;"></div>
            <div class="absolute bottom-0 left-1/3 w-96 h-96 bg-rose-500/20 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 4s;"></div>
            <div class="absolute top-1/4 left-1/2 w-64 h-64 bg-red-600/20 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 6s;"></div>
        </div>

        <!-- Grid Pattern -->
        <div
            class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.02)_1px,transparent_1px)] bg-[size:4rem_4rem]">
        </div>

        <!-- Robotic Elements -->
        <div class="absolute inset-0">
            <!-- Gears -->
            @for ($i = 1; $i <= 4; $i++)
                <div class="absolute w-12 h-12 border-2 border-rose-600/30 rounded-full animate-spin"
                    style="top: {{ rand(10, 80) }}%; left: {{ rand(10, 80) }}%; animation-duration: {{ 10 + $i * 2 }}s;">
                </div>
            @endfor

            <!-- Circuit Boards -->
            @for ($i = 1; $i <= 4; $i++)
                <div class="absolute w-16 h-0.5 bg-gradient-to-r from-transparent via-rose-500/50 to-transparent"
                    style="top: {{ rand(20, 70) }}%; left: {{ rand(10, 80) }}%; transform: rotate({{ rand(-45, 45) }}deg);">
                </div>
            @endfor

            <!-- LED Indicators -->
            @for ($i = 1; $i <= 6; $i++)
                <div class="absolute w-2 h-2 bg-rose-500 rounded-full animate-pulse"
                    style="top: {{ rand(15, 85) }}%; left: {{ rand(15, 85) }}%; animation-delay: {{ $i * 0.5 }}s;">
                </div>
            @endfor

            <!-- Robot Eyes -->
            @for ($i = 1; $i <= 3; $i++)
                <div class="absolute w-3 h-3 bg-rose-600 rounded-full animate-ping"
                    style="top: {{ rand(10, 90) }}%; left: {{ rand(10, 90) }}%; animation-duration: {{ 2 + $i }}s;">
                </div>
            @endfor

            <!-- Data Streams -->
            @for ($i = 1; $i <= 3; $i++)
                <div class="absolute w-0.5 h-32 bg-gradient-to-b from-rose-500/0 via-rose-500/50 to-rose-500/0 animate-pulse"
                    style="top: {{ rand(0, 60) }}%; left: {{ rand(20, 80) }}%; animation-delay: {{ $i }}s;">
                </div>
            @endfor

            <!-- Tech Particles -->
            @for ($i = 1; $i <= 5; $i++)
                <div class="absolute w-1 h-1 bg-white rounded-full animate-ping"
                    style="top: {{ rand(10, 90) }}%; left: {{ rand(10, 90) }}%; animation-duration: {{ 3 + $i * 0.5 }}s; animation-delay: {{ $i * 0.3 }}s;">
                </div>
            @endfor
        </div>
    </div>

    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-7xl bg-black/60 backdrop-blur-xl border border-rose-500/20 rounded-3xl shadow-2xl shadow-rose-900/30 overflow-hidden"
            x-data="{ activePanel: 'form' }">

            <div class="grid lg:grid-cols-[1.05fr,0.95fr] min-h-[600px]">

                <!-- Left Panel - Branding -->
                <div
                    class="relative p-8 lg:p-12 bg-gradient-to-br from-rose-600/10 to-red-700/10 border-r border-rose-500/20 hidden lg:flex flex-col justify-center">

                    <!-- Background Effects -->
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-rose-600/5 via-transparent to-red-700/5">
                        </div>
                        @for ($i = 1; $i <= 3; $i++)
                            <div class="absolute w-32 h-32 bg-rose-500/10 rounded-full blur-2xl animate-pulse"
                                style="top: {{ rand(10, 70) }}%; left: {{ rand(10, 70) }}%; animation-delay: {{ $i * 2 }}s;">
                            </div>
                        @endfor
                    </div>

                    <div class="relative z-10 space-y-8">
                        <!-- Logo -->
                        <div class="text-center">
                            <img src="{{ asset('images/LogoCompletoLogin.png') }}" alt="PromptVault"
                                class="max-w-[75%] h-auto mx-auto" x-show="activePanel === 'form'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100">
                        </div>

                        <!-- Welcome Message -->
                        <div class="text-center space-y-4">
                            <h2
                                class="text-2xl lg:text-3xl font-bold font-['Montserrat'] uppercase tracking-wide leading-tight">
                                {{ $brandingTitle }}
                            </h2>
                            <p class="text-sm lg:text-base text-slate-200 leading-relaxed max-w-md mx-auto">
                                {{ $brandingText }}
                            </p>
                        </div>

                        <!-- Features Section (optional slot) -->
                        <div>
                            {{ $features ?? '' }}
                        </div>

                        <!-- Social Media Links -->
                        <div class="text-center space-y-4">
                            <div>
                                <p class="text-xs text-slate-300">¿Necesitas ayuda con la plataforma?</p>
                                <p class="text-sm font-semibold">¡Contáctanos!</p>
                            </div>

                            <div class="flex justify-center gap-4">
                                <a href="#"
                                    class="group flex flex-col items-center gap-2 p-3 bg-rose-600/20 hover:bg-rose-600/30 border border-rose-500/30 rounded-xl transition-all duration-300 hover:scale-105"
                                    title="TikTok">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                                    </svg>
                                    <span class="text-xs">TikTok</span>
                                </a>

                                <a href="#"
                                    class="group flex flex-col items-center gap-2 p-3 bg-rose-600/20 hover:bg-rose-600/30 border border-rose-500/30 rounded-xl transition-all duration-300 hover:scale-105"
                                    title="Facebook">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                    <span class="text-xs">Facebook</span>
                                </a>

                                <a href="#"
                                    class="group flex flex-col items-center gap-2 p-3 bg-rose-600/20 hover:bg-rose-600/30 border border-rose-500/30 rounded-xl transition-all duration-300 hover:scale-105"
                                    title="Instagram">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                    <span class="text-xs">Instagram</span>
                                </a>

                                <a href="#"
                                    class="group flex flex-col items-center gap-2 p-3 bg-rose-600/20 hover:bg-rose-600/30 border border-rose-500/30 rounded-xl transition-all duration-300 hover:scale-105"
                                    title="WhatsApp">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488" />
                                    </svg>
                                    <span class="text-xs">WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Panel - Form Section -->
                <div class="relative p-6 sm:p-8 lg:p-12 flex items-center justify-center">

                    <!-- Decorative Lines -->
                    <div class="absolute inset-0 overflow-hidden pointer-events-none">
                        <div
                            class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-rose-500/50 to-transparent">
                        </div>
                        <div
                            class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-rose-500/50 to-transparent">
                        </div>
                        <div
                            class="absolute top-0 left-1/2 w-px h-full bg-gradient-to-b from-transparent via-rose-500/50 to-transparent">
                        </div>
                    </div>

                    <!-- Decorative Particles -->
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="absolute w-2 h-2 bg-rose-500 rounded-full animate-ping"
                            style="top: {{ rand(10, 90) }}%; left: {{ rand(10, 90) }}%; animation-delay: {{ $i * 0.5 }}s;">
                        </div>
                    @endfor

                    <!-- Form Content -->
                    <div class="relative z-10 w-full max-w-md space-y-6">
                        {{ $slot }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{ $scripts ?? '' }}

</body>

</html>
