<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento - PromptVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen flex items-center justify-center">
    <div class="text-center px-6">
        <!-- Logo/Icon -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-rose-500/20 rounded-full mb-6">
                <i class="fas fa-tools text-rose-500 text-4xl"></i>
            </div>
        </div>

        <!-- Título -->
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            En Mantenimiento
        </h1>

        <!-- Descripción -->
        <p class="text-lg text-gray-400 mb-8 max-w-md mx-auto">
            PromptVault está en mantenimiento en este momento. Por favor, intenta más tarde.
        </p>

        <!-- Detalles técnicos -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-6 mb-8 max-w-md mx-auto">
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between text-gray-400">
                    <span>Estado del Sistema:</span>
                    <span class="text-yellow-400 font-medium">En Mantenimiento</span>
                </div>
                <div class="flex items-center justify-between text-gray-400">
                    <span>Contacto:</span>
                    <span class="text-white">soporte@promptvault.com</span>
                </div>
                <div class="flex items-center justify-between text-gray-400">
                    <span>Hora:</span>
                    <span class="text-white">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Botón de login (si es admin) -->
        @if (auth()->check() && auth()->user()->esAdmin())
            <div class="space-y-3">
                <p class="text-gray-400 text-sm">Como administrador, tienes acceso total.</p>
                <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30">
                    <i class="fas fa-arrow-right mr-2"></i> Ir al Dashboard
                </a>
            </div>
        @else
            <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors shadow-lg shadow-rose-500/30">
                <i class="fas fa-sign-in-alt mr-2"></i> Volver al Login
            </a>
        @endif

        <!-- Footer -->
        <div class="mt-12 pt-8 border-t border-white/10">
            <p class="text-gray-500 text-xs">
                PromptVault © 2026 | Estado: Sistema en Mantenimiento
            </p>
        </div>
    </div>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>
