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
<div x-data="{ open: false, messages: [], input: '', loading: false }" 
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
        <div class="p-5 bg-slate-800/50 border-b border-slate-700 flex justify-between items-center backdrop-blur-sm">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-rose-600/20 flex items-center justify-center text-rose-500">
                    <i class="fas fa-brain"></i>
                </div>
                <div>
                    <h4 class="text-white font-semibold">Asistente IA</h4>
                    <small class="text-slate-400 text-xs block">Powered by Groq</small>
                </div>
            </div>
            <button @click="open = false" 
                    class="w-8 h-8 rounded-lg hover:bg-slate-700 text-slate-400 hover:text-white transition-colors flex items-center justify-center">
                <i class="fas fa-times"></i>
            </button>
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
                    input = '';
                    loading = true;
                    
                    fetch('{{ route('chatbot.ask') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ message: userMessage })
                    })
                    .then(r => r.json())
                    .then(data => {
                        loading = false;
                        messages.push({ 
                            role: 'assistant', 
                            content: data.response || 'Lo siento, hubo un error.',
                            related_prompts: data.related_prompts || []
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
