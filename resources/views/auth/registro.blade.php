<x-app-auth 
    title="Registro" 
    description="Únete a PromptVault. Registro seguro para gestionar tus prompts de IA de forma centralizada."
    brandingTitle="ÚNETE A LA PLATAFORMA"
    brandingText="Crea tu cuenta y comienza a gestionar tus prompts de IA de manera profesional con todas nuestras herramientas avanzadas.">
    
    <x-slot name="features">
        <div class="space-y-3">
            <p class="text-xs text-center text-slate-300">¿Qué puedes hacer en la plataforma?</p>
            <p class="text-sm text-center font-semibold">¡Explora nuestras funcionalidades!</p>
            
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col items-center gap-2 p-3 bg-rose-600/20 border border-rose-500/30 rounded-xl">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span class="text-xs">Biblioteca</span>
                </div>
                <div class="flex flex-col items-center gap-2 p-3 bg-rose-600/20 border border-rose-500/30 rounded-xl">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <span class="text-xs">Versionado</span>
                </div>
                <div class="flex flex-col items-center gap-2 p-3 bg-rose-600/20 border border-rose-500/30 rounded-xl">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                    <span class="text-xs">Colaboración</span>
                </div>
                <div class="flex flex-col items-center gap-2 p-3 bg-rose-600/20 border border-rose-500/30 rounded-xl">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"/>
                    </svg>
                    <span class="text-xs">IA Integrada</span>
                </div>
            </div>
        </div>
    </x-slot>
    
    @php($hasVerifyRoute = Route::has('register.verify'))
    <div x-data="{ 
        step: '{{ $hasVerifyRoute && request('step') === 'verify' ? 'verify' : 'register' }}',
        loading: false
    }">
        
        <!-- Step Indicator -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold transition-all"
                     :class="step === 'register' ? 'bg-rose-600' : 'bg-rose-600/50'">
                    1
                </div>
                <span class="text-sm" :class="step === 'register' ? 'text-white' : 'text-slate-400'">Datos</span>
            </div>
            @if($hasVerifyRoute)
                <div class="w-12 h-px bg-rose-500/30"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold transition-all"
                         :class="step === 'verify' ? 'bg-rose-600' : 'bg-rose-600/50'">
                        2
                    </div>
                    <span class="text-sm" :class="step === 'verify' ? 'text-white' : 'text-slate-400'">Verificación</span>
                </div>
            @endif
        </div>

        <!-- Form Header -->
        <div class="text-center space-y-2 mb-6">
            <h2 class="text-3xl font-bold font-['Montserrat']" x-text="step === 'verify' ? 'Verifica tu Email' : 'Crear Cuenta'"></h2>
            <p class="text-sm text-slate-300" x-text="step === 'verify' ? 'Ingresa el código de 6 dígitos' : 'Completa el formulario de registro'"></p>
        </div>

        <!-- Alerts -->
        @if($errors->any())
        <div class="flex items-start gap-3 p-4 bg-red-500/20 border border-red-500/50 rounded-xl mb-4" x-data="{ show: true }" x-show="show" x-transition>
            <div class="text-2xl">⚠️</div>
            <div class="flex-1 text-sm">{{ $errors->first() }}</div>
            <button @click="show = false" class="text-slate-400 hover:text-white">✕</button>
        </div>
        @endif

        @if(session('success'))
        <div class="flex items-start gap-3 p-4 bg-green-500/20 border border-green-500/50 rounded-xl mb-4" x-data="{ show: true }" x-show="show" x-transition>
            <div class="text-2xl">✅</div>
            <div class="flex-1 text-sm">{{ session('success') }}</div>
            <button @click="show = false" class="text-slate-400 hover:text-white">✕</button>
        </div>
        @endif

        @if($hasVerifyRoute)
            <!-- Step 2: Verification Form -->
            <form method="POST" action="{{ route('register.verify') }}" class="space-y-5" 
                  x-show="step === 'verify'"
                  @submit="loading = true">
                @csrf
                <input type="hidden" name="email" value="{{ old('email', request('email')) }}">
                
                <div class="space-y-2">
                    <label for="verification_code" class="block text-sm font-medium text-slate-200">Código de Verificación</label>
                    <input
                        type="text"
                        id="verification_code"
                        name="verification_code"
                        maxlength="6"
                        required
                        placeholder="000000"
                        class="w-full px-4 py-3 bg-white/5 border border-rose-500/30 rounded-xl text-white text-center text-2xl tracking-widest placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-300">
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3 bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-500 hover:to-red-500 rounded-xl font-semibold text-white shadow-lg shadow-rose-900/50 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50"
                    :disabled="loading">
                    <span x-show="!loading">VERIFICAR Y COMPLETAR REGISTRO</span>
                    <span x-show="loading" class="flex items-center justify-center gap-2" style="display: none;">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Verificando...
                    </span>
                </button>
            </form>
        @endif

        <!-- Step 1: Registration Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5" 
              x-show="step === 'register'"
              @submit="loading = true">
            @csrf

            <!-- Name Field -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-slate-200">Nombre Completo</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Tu nombre completo"
                    class="w-full px-4 py-3 bg-white/5 border border-rose-500/30 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-300">
            </div>

            <!-- Email Field -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-slate-200">Correo Electrónico</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="tu@email.com"
                    class="w-full px-4 py-3 bg-white/5 border border-rose-500/30 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-300">
            </div>

            <!-- Password Field -->
            <div class="space-y-2" x-data="{ showPassword: false }">
                <label for="password" class="block text-sm font-medium text-slate-200">Contraseña</label>
                <div class="relative">
                    <input
                        :type="showPassword ? 'text' : 'password'"
                        id="password"
                        name="password"
                        required
                        placeholder="Mínimo 8 caracteres"
                        class="w-full px-4 pr-12 py-3 bg-white/5 border border-rose-500/30 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-300">
                    <button 
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-white">
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

            <!-- Confirm Password Field -->
            <div class="space-y-2" x-data="{ showPassword: false }">
                <label for="password_confirmation" class="block text-sm font-medium text-slate-200">Confirmar Contraseña</label>
                <div class="relative">
                    <input
                        :type="showPassword ? 'text' : 'password'"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        placeholder="Repite tu contraseña"
                        class="w-full px-4 pr-12 py-3 bg-white/5 border border-rose-500/30 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-300">
                    <button 
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-white">
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

            <!-- Terms and Conditions -->
            <div class="flex items-start gap-3">
                <input
                    id="acepta_terminos"
                    name="acepta_terminos"
                    type="checkbox"
                    value="1"
                    required
                    class="mt-1 h-4 w-4 rounded border-rose-500/40 bg-white/5 text-rose-500 focus:ring-2 focus:ring-rose-500">
                <label for="acepta_terminos" class="text-sm text-slate-200 leading-relaxed">
                    Acepto los <a href="#" class="text-rose-400 hover:text-rose-300 font-semibold">Términos y Condiciones</a> y la <a href="#" class="text-rose-400 hover:text-rose-300 font-semibold">Política de Privacidad</a>.
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full py-3 bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-500 hover:to-red-500 rounded-xl font-semibold text-white shadow-lg shadow-rose-900/50 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50"
                :disabled="loading">
                <span x-show="!loading">CREAR CUENTA</span>
                <span x-show="loading" class="flex items-center justify-center gap-2" style="display: none;">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Procesando...
                </span>
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center pt-4 border-t border-rose-500/20 mt-6">
            <p class="text-sm text-slate-300">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="text-rose-400 hover:text-rose-300 font-semibold transition-colors">
                    Inicia sesión
                </a>
            </p>
        </div>
    </div>

</x-app-auth>
