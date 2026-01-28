{{-- Chatbot Widget - Tailwind + Alpine --}}
<script>
function parseMarkdown(text) {
    return text
        .replace(/\*\*(.+?)\*\*/g, '<strong class="font-semibold">$1</strong>')
        .replace(/\*(.+?)\*/g, '<em>$1</em>')
        .replace(/\n\* /g, '\n• ')
        .replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" class="text-rose-400 hover:text-rose-300 underline" target="_blank">$1</a>')
        .replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" class="text-rose-400 hover:text-rose-300 underline break-all" target="_blank">$1</a>')
        .replace(/\n\n/g, '<br><br>')
        .replace(/\n/g, '<br>');
}
</script>

@auth
<div x-data="{
        open: false,
        messages: [],
        input: '',
        loading: false,
        provider: '{{ config('services.chatbot.default_provider', 'groq') }}',
        showProviderMenu: false,
        providers: [
            { value: 'groq', name: 'Groq (Llama 3.3)' },
            { value: 'claude', name: 'Claude (Anthropic)' }
        ],
        getProviderName() {
            const p = this.providers.find(p => p.value === this.provider);
            return p ? p.name : this.provider;
        }
     }"
     class="fixed bottom-8 right-8 z-50 font-sans">

    {{-- Botón flotante --}}
    <button @click="open = !open"
            class="w-16 h-16 rounded-full bg-gradient-to-br from-rose-600 to-rose-700 text-white shadow-lg shadow-rose-500/40 hover:shadow-xl hover:scale-110 transition-all duration-300 flex items-center justify-center">
        <i class="fas fa-robot text-2xl" x-show="!open"></i>
        <i class="fas fa-times text-2xl" x-show="open" style="display:none;"></i>
    </button>

    {{-- Ventana del chat --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-75 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-75"
         style="display:none;"
         class="absolute bottom-20 right-0 w-96 h-[600px] bg-slate-900 rounded-3xl shadow-2xl border border-slate-700 flex flex-col overflow-hidden origin-bottom-right">

        {{-- Header --}}
        <div class="p-5 bg-slate-800/50 border-b border-slate-700 backdrop-blur-sm">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-rose-600/20 flex items-center justify-center text-rose-500">
                        <i class="fas fa-brain"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold">Asistente IA</h4>
                        {{-- Provider selector --}}
                        <div class="relative">
                            <button @click="showProviderMenu = !showProviderMenu"
                                    class="text-xs text-slate-400 hover:text-rose-400 transition-colors flex items-center gap-1">
                                <span>Powered by</span>
                                <span class="text-rose-400" x-text="provider === 'groq' ? 'Groq' : 'Claude'"></span>
                                <i class="fas fa-chevron-down text-[10px]" :class="showProviderMenu && 'rotate-180'"></i>
                            </button>
                            {{-- Dropdown menu --}}
                            <div x-show="showProviderMenu"
                                 @click.away="showProviderMenu = false"
                                 x-transition
                                 style="display:none;"
                                 class="absolute top-6 left-0 w-48 bg-slate-800 border border-slate-700 rounded-lg shadow-xl z-50 py-1">
                                <template x-for="p in providers" :key="p.value">
                                    <button @click="provider = p.value; showProviderMenu = false"
                                            class="w-full px-3 py-2 text-left text-sm hover:bg-slate-700 transition-colors flex items-center justify-between"
                                            :class="provider === p.value ? 'text-rose-400' : 'text-slate-300'">
                                        <span x-text="p.name"></span>
                                        <i x-show="provider === p.value" class="fas fa-check text-xs"></i>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('chat.index') }}"
                       class="w-8 h-8 rounded-lg hover:bg-slate-700 text-slate-400 hover:text-white transition-colors flex items-center justify-center"
                       title="Abrir chat completo">
                        <i class="fas fa-expand-alt"></i>
                    </a>
                    <button @click="open = false"
                            class="w-8 h-8 rounded-lg hover:bg-slate-700 text-slate-400 hover:text-white transition-colors flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Messages --}}
        <div x-ref="messageContainer"
             class="flex-1 overflow-y-auto p-5 flex flex-col gap-4 scroll-smooth"
             x-init="messages.push({ role: 'assistant', content: '¡Hola! Soy tu asistente inteligente. Puedo ayudarte a encontrar, mejorar o analizar tus prompts. ¿Qué necesitas hoy?' })">

            <template x-for="(message, index) in messages" :key="index">
                <div class="flex gap-3 items-start" :class="message.role === 'user' ? 'flex-row-reverse' : ''">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 text-xs"
                         :class="message.role === 'assistant' ? 'bg-rose-600/20 text-rose-500' : 'bg-blue-600/20 text-blue-500'">
                        <i :class="message.role === 'assistant' ? 'fas fa-robot' : 'fas fa-user'"></i>
                    </div>
                    <div class="max-w-[85%]">
                        <div class="px-4 py-3 rounded-2xl text-sm"
                             :class="message.role === 'assistant' ? 'bg-slate-800 border border-slate-700 text-slate-200 rounded-tl-sm' : 'bg-rose-600 text-white rounded-tr-sm'">
                            <p x-html="message.role === 'assistant' ? parseMarkdown(message.content) : message.content" class="leading-relaxed"></p>
                        </div>

                        {{-- Provider badge for assistant messages --}}
                        <template x-if="message.role === 'assistant' && message.provider">
                            <div class="mt-1 text-[10px] text-slate-500 flex items-center gap-1">
                                <i class="fas fa-microchip"></i>
                                <span x-text="message.provider"></span>
                            </div>
                        </template>

                        {{-- Related Prompts --}}
                        <template x-if="message.related_prompts && message.related_prompts.length > 0">
                            <div class="mt-2 space-y-2">
                                <template x-for="prompt in message.related_prompts" :key="prompt.id">
                                    <a :href="prompt.url"
                                       class="block px-3 py-2 bg-slate-800/50 border border-slate-700 rounded-lg hover:bg-slate-700/50 hover:border-rose-500/50 transition-all group">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-bookmark text-rose-500 text-xs"></i>
                                            <span class="text-sm text-slate-200 group-hover:text-white font-medium" x-text="prompt.titulo"></span>
                                        </div>
                                        <p class="text-xs text-slate-400 mt-1 pl-5" x-text="prompt.descripcion"></p>
                                    </a>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Loading --}}
            <div x-show="loading" class="flex gap-3 items-start" style="display:none;">
                <div class="w-7 h-7 rounded-full bg-rose-600/20 text-rose-500 flex items-center justify-center flex-shrink-0 text-xs">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="px-4 py-3 bg-slate-800 border border-slate-700 rounded-2xl rounded-tl-sm text-slate-200">
                    <div class="flex gap-1">
                        <span class="w-2 h-2 bg-slate-600 rounded-full animate-bounce" style="animation-delay: 0s"></span>
                        <span class="w-2 h-2 bg-slate-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                        <span class="w-2 h-2 bg-slate-600 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Input Area --}}
        <div class="p-4 bg-slate-800/50 border-t border-slate-700 backdrop-blur-sm">
            <form @submit.prevent="
                if (input.trim()) {
                    messages.push({ role: 'user', content: input });
                    const userMessage = input;
                    const selectedProvider = provider;
                    input = '';
                    loading = true;

                    fetch('{{ route('chatbot.ask') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ message: userMessage, provider: selectedProvider })
                    })
                    .then(r => r.json())
                    .then(data => {
                        loading = false;
                        messages.push({
                            role: 'assistant',
                            content: data.response || data.error || 'Lo siento, hubo un error.',
                            related_prompts: data.related_prompts || [],
                            provider: data.provider || null
                        });
                        $nextTick(() => $refs.messageContainer.scrollTop = $refs.messageContainer.scrollHeight);
                    })
                    .catch(() => {
                        loading = false;
                        messages.push({ role: 'assistant', content: 'Error de conexión. Inténtalo de nuevo.' });
                    });
                }
            " class="relative">
                <input x-model="input"
                       type="text"
                       placeholder="Pregunta sobre tus prompts..."
                       class="w-full pl-4 pr-12 py-3 bg-slate-900/80 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
                <button type="submit"
                        class="absolute right-1.5 top-1.5 w-9 h-9 bg-rose-600 hover:bg-rose-700 text-white rounded-lg transition-colors flex items-center justify-center">
                    <i class="fas fa-paper-plane text-sm"></i>
                </button>
            </form>
            <p class="text-center mt-2 text-xs text-slate-500">La IA puede cometer errores. Verifica la información importante.</p>
        </div>
    </div>
</div>
@endauth

{{-- Chat Widget para usuarios no autenticados - Solo icono, modal para login --}}
@guest
<div x-data="{ open: false }" class="fixed bottom-8 right-8 z-50 font-sans">
    {{-- Botón flotante --}}
    <button @click="open = !open"
            class="w-16 h-16 rounded-full bg-gradient-to-br from-rose-600 to-rose-700 text-white shadow-lg shadow-rose-500/40 hover:shadow-xl hover:scale-110 transition-all duration-300 flex items-center justify-center">
        <i class="fas fa-robot text-2xl" x-show="!open"></i>
        <i class="fas fa-times text-2xl" x-show="open" style="display:none;"></i>
    </button>

    {{-- Ventana del chat (mostrar solo icono + CTA) --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-75 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-75"
         style="display:none;"
         class="absolute bottom-20 right-0 w-96 h-[500px] bg-slate-900 rounded-3xl shadow-2xl border border-slate-700 flex flex-col overflow-hidden origin-bottom-right">

        {{-- Header --}}
        <div class="p-5 bg-slate-800/50 border-b border-slate-700 flex justify-between items-center backdrop-blur-sm">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-rose-600/20 flex items-center justify-center text-rose-500">
                    <i class="fas fa-brain"></i>
                </div>
                <div>
                    <h4 class="text-white font-semibold">Asistente IA</h4>
                    <small class="text-slate-400 text-xs block">Powered by Groq & Claude</small>
                </div>
            </div>
            <button @click="open = false"
                    class="w-8 h-8 rounded-lg hover:bg-slate-700 text-slate-400 hover:text-white transition-colors flex items-center justify-center">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Content --}}
        <div class="flex-1 flex flex-col items-center justify-center gap-6 p-8 text-center">
            <div class="w-20 h-20 rounded-full bg-rose-600/20 flex items-center justify-center">
                <i class="fas fa-robot text-3xl text-rose-500"></i>
            </div>

            <div class="space-y-2">
                <h3 class="text-xl font-semibold text-white">Desbloquea el Agente IA</h3>
                <p class="text-slate-400 text-sm">Inicia sesión o registrate para usar el asistente inteligente de PromptVault</p>
            </div>

            <div class="flex flex-col gap-3 w-full">
                <a href="{{ route('login') }}"
                   class="px-4 py-3 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
                <a href="{{ route('register') }}"
                   class="px-4 py-3 bg-slate-800 border border-slate-700 hover:bg-slate-700 text-slate-200 font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus"></i> Registrarse
                </a>
            </div>
        </div>
    </div>
</div>
@endguest
