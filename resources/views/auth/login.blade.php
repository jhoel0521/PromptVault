<x-app-auth 
    title="Acceso Sistema" 
    description="Accede a tu cuenta en PromptVault. Sistema de gestión centralizada de prompts de IA con versionado, organización y colaboración."
    brandingTitle="GESTIONA TUS PROMPTS CON INTELIGENCIA"
    brandingText="Sistema de gestión centralizada de prompts de IA con versionado automático, colaboración en tiempo real y organización inteligente por categorías y etiquetas.">
    
    <x-slot name="features">
        <div class="space-y-3">
            <p class="text-xs text-center text-slate-300">¿Qué puedes hacer en la plataforma?</p>
            <p class="text-sm text-center font-semibold">¡Explora nuestras funcionalidades!</p>
            
            <div class="grid grid-cols-2 gap-3">
                <a href="#" class="flex flex-col items-center gap-2 p-3 bg-rose-600/20 border border-rose-500/30 rounded-xl hover:bg-rose-600/30 transition-all duration-300 hover:scale-105" title="Biblioteca de Prompts">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span class="text-xs">Biblioteca</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-3 bg-rose-600/20 border border-rose-500/30 rounded-xl hover:bg-rose-600/30 transition-all duration-300 hover:scale-105" title="Versionado">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <span class="text-xs">Versionado</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-3 bg-rose-600/20 border border-rose-500/30 rounded-xl hover:bg-rose-600/30 transition-all duration-300 hover:scale-105" title="Colaboración">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                    <span class="text-xs">Colaboración</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-3 bg-rose-600/20 border border-rose-500/30 rounded-xl hover:bg-rose-600/30 transition-all duration-300 hover:scale-105" title="IA Integrada">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <span class="text-xs">IA Integrada</span>
                </a>
            </div>
        </div>
    </x-slot>
    
    <!-- Form Header -->
    <div class="text-center space-y-2" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
        <h2 class="text-3xl font-bold font-['Montserrat']" 
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">
            Iniciar Sesión
        </h2>
        <p class="text-sm text-slate-300">Ingresa tus credenciales para continuar</p>
    </div>

    <!-- Alerts -->
    @if($errors->any())
    <div class="flex items-start gap-3 p-4 bg-red-500/20 border border-red-500/50 rounded-xl" x-data="{ show: true }" x-show="show" x-transition>
        <div class="text-2xl">⚠️</div>
        <div class="flex-1 text-sm">{{ $errors->first() }}</div>
        <button @click="show = false" class="text-slate-400 hover:text-white">✕</button>
    </div>
    @endif

    @if(session('success'))
    <div class="flex items-start gap-3 p-4 bg-green-500/20 border border-green-500/50 rounded-xl" x-data="{ show: true }" x-show="show" x-transition>
        <div class="text-2xl">✅</div>
        <div class="flex-1 text-sm">{{ session('success') }}</div>
        <button @click="show = false" class="text-slate-400 hover:text-white">✕</button>
    </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5" 
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
        </div>

        <!-- Password Field -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-slate-200">Contraseña</label>
            <div class="relative" x-data="{ showPassword: false }">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input
                    :type="showPassword ? 'text' : 'password'"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Escribe tu contraseña aquí..."
                    class="w-full pl-12 pr-12 py-3 bg-white/5 border border-rose-500/30 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-300">
                <button 
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-white transition-colors">
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Remember & Forgot Password -->
        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 cursor-pointer group">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-rose-500/30 bg-white/5 text-rose-600 focus:ring-2 focus:ring-rose-500 focus:ring-offset-0 transition-all">
                <span class="text-slate-300 group-hover:text-white transition-colors">Recordarme</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-rose-400 hover:text-rose-300 transition-colors">
                ¿Olvidaste tu contraseña?
            </a>
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="relative w-full py-3 bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-500 hover:to-red-500 rounded-xl font-semibold text-white shadow-lg shadow-rose-900/50 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="loading">
            <span x-show="!loading">ACCESO SISTEMA</span>
            <span x-show="loading" class="flex items-center justify-center gap-2" style="display: none;">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Cargando...
            </span>
        </button>
    </form>

    <!-- Footer -->
    <div class="text-center pt-4 border-t border-rose-500/20">
        <p class="text-sm text-slate-300">
            ¿No tienes una cuenta? 
            <a href="{{ route('register') }}" class="text-rose-400 hover:text-rose-300 font-semibold transition-colors">
                ¡Regístrate aquí!
            </a>
        </p>
    </div>

</x-app-auth>
