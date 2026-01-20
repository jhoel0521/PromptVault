<x-app-auth 
    title="Recuperar Contraseña" 
    description="Recupera tu contraseña en PromptVault. Sistema de gestión de prompts de IA."
    brandingTitle="RECUPERA TU ACCESO DE FORMA SEGURA"
    brandingText="Restablece tu contraseña de forma segura con verificación por email. Tu cuenta está protegida con encriptación avanzada y múltiples capas de seguridad.">
    
    <!-- Form Header -->
    <div class="text-center space-y-2 mb-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <h2 class="text-3xl font-bold font-['Montserrat']" 
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">
            Recuperar Contraseña
        </h2>
        <p class="text-sm text-slate-300">Ingresa tu correo electrónico para continuar</p>
    </div>

    <!-- Alerts -->
    @if($errors->any())
    <div class="flex items-start gap-3 p-4 bg-red-500/20 border border-red-500/50 rounded-xl mb-4" x-data="{ show: true }" x-show="show" x-transition>
        <div class="text-2xl">⚠️</div>
        <div class="flex-1 text-sm">{{ $errors->first() }}</div>
        <button @click="show = false" class="text-slate-400 hover:text-white">✕</button>
    </div>
    @endif

    @if(session('success') || session('status'))
    <div class="flex items-start gap-3 p-4 bg-green-500/20 border border-green-500/50 rounded-xl mb-4" x-data="{ show: true }" x-show="show" x-transition>
        <div class="text-2xl">✅</div>
        <div class="flex-1 text-sm">{{ session('success') ?? session('status') }}</div>
        <button @click="show = false" class="text-slate-400 hover:text-white">✕</button>
    </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5" 
          x-data="{ loading: false }" 
          @submit="loading = true">
        @csrf

        <!-- Email Field -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-slate-200">Correo Electrónico</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="Escribe tu email aquí..."
                    class="w-full pl-12 pr-4 py-3 bg-white/5 border border-rose-500/30 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-300">
            </div>
            <p class="text-xs text-slate-400">Te enviaremos un enlace para restablecer tu contraseña</p>
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="w-full py-3 bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-500 hover:to-red-500 rounded-xl font-semibold text-white shadow-lg shadow-rose-900/50 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="loading">
            <span x-show="!loading">ENVIAR ENLACE DE RECUPERACIÓN</span>
            <span x-show="loading" class="flex items-center justify-center gap-2" style="display: none;">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Enviando...
            </span>
        </button>
    </form>

    <!-- Info Box -->
    <div class="p-4 bg-blue-500/10 border border-blue-500/30 rounded-xl space-y-2">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">
                <p class="text-sm text-blue-200 font-medium">¿No recibiste el email?</p>
                <p class="text-xs text-blue-300/80 mt-1">Revisa tu carpeta de spam o correo no deseado. El enlace expira en 60 minutos.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center pt-4 border-t border-rose-500/20 space-y-2">
        <p class="text-sm text-slate-300">
            ¿Recordaste tu contraseña? 
            <a href="{{ route('login') }}" class="text-rose-400 hover:text-rose-300 font-semibold transition-colors">
                Inicia sesión
            </a>
        </p>
        <p class="text-sm text-slate-300">
            ¿No tienes cuenta? 
            <a href="{{ route('register') }}" class="text-rose-400 hover:text-rose-300 font-semibold transition-colors">
                Regístrate aquí
            </a>
        </p>
    </div>

</x-app-auth>
