<x-app-layout :title="'Chat IA - PromptVault'">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div x-data="chatApp()" class="flex gap-6 h-[calc(100vh-8rem)]">

            {{-- Sidebar: Historial --}}
            <div class="w-72 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl flex flex-col overflow-hidden">
                {{-- Header --}}
                <div class="p-4 border-b border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fas fa-history text-rose-600"></i>
                            Historial
                        </h2>
                        <button @click="clearAllHistory()"
                                x-show="Object.keys(groupedHistory).length > 0"
                                class="text-xs text-slate-500 hover:text-rose-600 transition-colors"
                                title="Limpiar historial">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <button @click="startNewChat()"
                            class="w-full px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i>
                        Nuevo Chat
                    </button>
                </div>

                {{-- History List --}}
                <div class="flex-1 overflow-y-auto p-3 space-y-4">
                    <template x-if="Object.keys(groupedHistory).length === 0">
                        <div class="text-center py-8 text-slate-500 dark:text-slate-400">
                            <i class="fas fa-comments text-3xl mb-2 opacity-50"></i>
                            <p class="text-sm">No hay conversaciones aún</p>
                        </div>
                    </template>

                    <template x-for="(items, date) in groupedHistory" :key="date">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase mb-2 px-2"
                               x-text="formatDate(date)"></p>
                            <div class="space-y-1">
                                <template x-for="item in items" :key="item.id">
                                    <div class="group relative">
                                        <button @click="loadConversation(item)"
                                                class="w-full text-left px-3 py-2 rounded-lg text-sm transition-colors"
                                                :class="selectedConversation?.id === item.id
                                                    ? 'bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-300'
                                                    : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700'">
                                            <p class="truncate font-medium" x-text="item.question"></p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 flex items-center gap-1">
                                                <i class="fas fa-microchip"></i>
                                                <span x-text="item.provider"></span>
                                            </p>
                                        </button>
                                        <button @click.stop="deleteConversation(item.id)"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 text-slate-400 hover:text-rose-600 transition-all p-1">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Main Chat Area --}}
            <div class="flex-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl flex flex-col overflow-hidden">
                {{-- Header --}}
                <div class="p-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-900/20 flex items-center justify-center">
                            <i class="fas fa-robot text-rose-600 text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-slate-900 dark:text-white">Chat IA</h1>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Asistente inteligente para tus prompts</p>
                        </div>
                    </div>

                    {{-- Provider Selector --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                            <i class="fas fa-microchip text-rose-600"></i>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-200" x-text="getProviderName()"></span>
                            <i class="fas fa-chevron-down text-xs text-slate-500" :class="open && 'rotate-180'"></i>
                        </button>
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition
                             style="display: none;"
                             class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-xl z-50 py-1">
                            <template x-for="p in providers" :key="p.value">
                                <button @click="provider = p.value; open = false"
                                        class="w-full px-4 py-2 text-left text-sm hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors flex items-center justify-between"
                                        :class="provider === p.value ? 'text-rose-600' : 'text-slate-700 dark:text-slate-300'">
                                    <span x-text="p.name"></span>
                                    <i x-show="provider === p.value" class="fas fa-check text-xs"></i>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Messages Area --}}
                <div x-ref="messagesContainer" class="flex-1 overflow-y-auto p-6 space-y-6">
                    {{-- Welcome Message --}}
                    <template x-if="messages.length === 0">
                        <div class="h-full flex flex-col items-center justify-center text-center py-12">
                            <div class="w-20 h-20 rounded-full bg-rose-100 dark:bg-rose-900/20 flex items-center justify-center mb-4">
                                <i class="fas fa-robot text-4xl text-rose-600"></i>
                            </div>
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                                ¡Hola! Soy tu Asistente IA
                            </h2>
                            <p class="text-slate-600 dark:text-slate-400 max-w-md mb-6">
                                Puedo ayudarte a encontrar, mejorar o analizar tus prompts. También puedo crear nuevos prompts basados en tus ideas.
                            </p>
                            <div class="flex flex-wrap gap-2 justify-center">
                                <button @click="input = '¿Qué prompts tengo disponibles?'; sendMessage()"
                                        class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg text-sm hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                                    <i class="fas fa-list mr-2"></i>Ver mis prompts
                                </button>
                                <button @click="input = 'Ayúdame a crear un prompt para...'; $refs.inputField.focus()"
                                        class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg text-sm hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                                    <i class="fas fa-plus mr-2"></i>Crear prompt
                                </button>
                                <button @click="input = '¿Cómo puedo mejorar mis prompts?'; sendMessage()"
                                        class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg text-sm hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                                    <i class="fas fa-lightbulb mr-2"></i>Consejos
                                </button>
                            </div>
                        </div>
                    </template>

                    {{-- Messages --}}
                    <template x-for="(message, index) in messages" :key="index">
                        <div class="flex gap-4" :class="message.role === 'user' ? 'flex-row-reverse' : ''">
                            {{-- Avatar --}}
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center"
                                     :class="message.role === 'assistant'
                                        ? 'bg-rose-100 dark:bg-rose-900/20 text-rose-600'
                                        : 'bg-blue-100 dark:bg-blue-900/20 text-blue-600'">
                                    <i :class="message.role === 'assistant' ? 'fas fa-robot' : 'fas fa-user'"></i>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 max-w-[80%]" :class="message.role === 'user' && 'flex flex-col items-end'">
                                <div class="px-4 py-3 rounded-2xl"
                                     :class="message.role === 'assistant'
                                        ? 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-tl-sm'
                                        : 'bg-rose-600 text-white rounded-tr-sm'">
                                    <div x-html="message.role === 'assistant' ? parseMarkdown(message.content) : message.content"
                                         class="prose prose-sm dark:prose-invert max-w-none"></div>
                                </div>

                                {{-- Provider badge --}}
                                <template x-if="message.role === 'assistant' && message.provider">
                                    <div class="mt-1 text-xs text-slate-500 flex items-center gap-1">
                                        <i class="fas fa-microchip"></i>
                                        <span x-text="message.provider"></span>
                                    </div>
                                </template>

                                {{-- Related Prompts --}}
                                <template x-if="message.related_prompts && message.related_prompts.length > 0">
                                    <div class="mt-3 space-y-2">
                                        <p class="text-xs font-semibold text-slate-600 dark:text-slate-400">Prompts relacionados:</p>
                                        <template x-for="prompt in message.related_prompts" :key="prompt.id">
                                            <a :href="prompt.url"
                                               class="block px-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg hover:border-rose-500 transition-all group">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-bookmark text-rose-500 text-sm"></i>
                                                    <span class="font-medium text-slate-800 dark:text-slate-200 group-hover:text-rose-600" x-text="prompt.titulo"></span>
                                                </div>
                                                <p class="text-sm text-slate-500 mt-1 pl-6" x-text="prompt.descripcion"></p>
                                            </a>
                                        </template>
                                    </div>
                                </template>

                                {{-- Create Prompt Action --}}
                                <template x-if="message.role === 'assistant' && message.canCreatePrompt">
                                    <div class="mt-3">
                                        <button @click="openCreatePromptModal(message)"
                                                class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                                            <i class="fas fa-plus"></i>
                                            Guardar como Prompt
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    {{-- Loading indicator --}}
                    <div x-show="loading" class="flex gap-4" style="display: none;">
                        <div class="w-10 h-10 rounded-full bg-rose-100 dark:bg-rose-900/20 text-rose-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="px-4 py-3 bg-slate-100 dark:bg-slate-700 rounded-2xl rounded-tl-sm">
                            <div class="flex gap-1">
                                <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0s"></span>
                                <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                                <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Input Area --}}
                <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                    <form @submit.prevent="sendMessage()" class="flex gap-3">
                        <div class="flex-1 relative">
                            <input x-ref="inputField"
                                   x-model="input"
                                   type="text"
                                   placeholder="Escribe tu mensaje..."
                                   class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-700 border-0 rounded-xl text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-rose-500"
                                   :disabled="loading">
                        </div>
                        <button type="submit"
                                :disabled="loading || !input.trim()"
                                class="px-6 py-3 bg-rose-600 hover:bg-rose-700 disabled:bg-slate-400 text-white font-medium rounded-xl transition-colors flex items-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            <span class="hidden sm:inline">Enviar</span>
                        </button>
                    </form>
                    <p class="text-center mt-2 text-xs text-slate-500">
                        La IA puede cometer errores. Verifica la información importante.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Prompt Modal --}}
    <div x-show="showCreatePromptModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div @click.away="showCreatePromptModal = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-plus-circle text-rose-600"></i>
                        Crear Nuevo Prompt
                    </h3>
                    <button @click="showCreatePromptModal = false" class="text-slate-500 hover:text-slate-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form @submit.prevent="createPrompt()">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Título</label>
                            <input x-model="newPrompt.titulo"
                                   type="text"
                                   required
                                   maxlength="150"
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-rose-500 focus:border-transparent"
                                   placeholder="Título del prompt">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Descripción</label>
                            <input x-model="newPrompt.descripcion"
                                   type="text"
                                   maxlength="500"
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-rose-500 focus:border-transparent"
                                   placeholder="Breve descripción (opcional)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Contenido</label>
                            <textarea x-model="newPrompt.contenido"
                                      required
                                      rows="8"
                                      class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-rose-500 focus:border-transparent"
                                      placeholder="Contenido del prompt..."></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button"
                                @click="showCreatePromptModal = false"
                                class="px-4 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium">
                            Cancelar
                        </button>
                        <button type="submit"
                                :disabled="creatingPrompt"
                                class="px-6 py-2 bg-rose-600 hover:bg-rose-700 disabled:bg-slate-400 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                            <i class="fas fa-save" x-show="!creatingPrompt"></i>
                            <i class="fas fa-spinner fa-spin" x-show="creatingPrompt" style="display: none;"></i>
                            Guardar Prompt
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function parseMarkdown(text) {
        return text
            .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.+?)\*/g, '<em>$1</em>')
            .replace(/\n\* /g, '\n• ')
            .replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" class="text-rose-600 hover:text-rose-700 underline" target="_blank">$1</a>')
            .replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" class="text-rose-600 hover:text-rose-700 underline break-all" target="_blank">$1</a>')
            .replace(/\n\n/g, '<br><br>')
            .replace(/\n/g, '<br>');
    }

    function chatApp() {
        return {
            messages: [],
            input: '',
            loading: false,
            provider: '{{ $defaultProvider }}',
            providers: @json($providers),
            groupedHistory: @json($groupedHistory),
            selectedConversation: null,
            showCreatePromptModal: false,
            creatingPrompt: false,
            newPrompt: {
                titulo: '',
                descripcion: '',
                contenido: ''
            },

            getProviderName() {
                const p = this.providers.find(p => p.value === this.provider);
                return p ? p.name : this.provider;
            },

            formatDate(dateStr) {
                const date = new Date(dateStr);
                const today = new Date();
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);

                if (date.toDateString() === today.toDateString()) {
                    return 'Hoy';
                } else if (date.toDateString() === yesterday.toDateString()) {
                    return 'Ayer';
                } else {
                    return date.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
                }
            },

            startNewChat() {
                this.messages = [];
                this.selectedConversation = null;
                this.$refs.inputField?.focus();
            },

            loadConversation(item) {
                this.selectedConversation = item;
                this.messages = [
                    { role: 'user', content: item.question },
                    {
                        role: 'assistant',
                        content: item.response,
                        provider: item.provider,
                        related_prompts: item.related_prompts || []
                    }
                ];
                this.$nextTick(() => {
                    this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                });
            },

            async deleteConversation(id) {
                if (!confirm('¿Eliminar esta conversación?')) return;

                try {
                    const response = await fetch(`/chat/history/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (response.ok) {
                        // Remove from grouped history
                        for (const date in this.groupedHistory) {
                            this.groupedHistory[date] = this.groupedHistory[date].filter(item => item.id !== id);
                            if (this.groupedHistory[date].length === 0) {
                                delete this.groupedHistory[date];
                            }
                        }

                        if (this.selectedConversation?.id === id) {
                            this.startNewChat();
                        }
                    }
                } catch (error) {
                    console.error('Error deleting conversation:', error);
                }
            },

            async clearAllHistory() {
                if (!confirm('¿Eliminar todo el historial de conversaciones?')) return;

                try {
                    const response = await fetch('/chat/history', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (response.ok) {
                        this.groupedHistory = {};
                        this.startNewChat();
                    }
                } catch (error) {
                    console.error('Error clearing history:', error);
                }
            },

            async sendMessage() {
                if (!this.input.trim() || this.loading) return;

                const userMessage = this.input.trim();
                this.messages.push({ role: 'user', content: userMessage });
                this.input = '';
                this.loading = true;
                this.selectedConversation = null;

                this.$nextTick(() => {
                    this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                });

                try {
                    const response = await fetch('{{ route("chatbot.ask") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            message: userMessage,
                            provider: this.provider
                        })
                    });

                    const data = await response.json();

                    this.messages.push({
                        role: 'assistant',
                        content: data.response || data.error || 'Lo siento, hubo un error.',
                        provider: data.provider || null,
                        related_prompts: data.related_prompts || [],
                        canCreatePrompt: data.response && data.response.length > 50
                    });

                    // Add to history
                    const today = new Date().toISOString().split('T')[0];
                    if (!this.groupedHistory[today]) {
                        this.groupedHistory[today] = [];
                    }
                    this.groupedHistory[today].unshift({
                        id: Date.now(),
                        question: userMessage,
                        response: data.response,
                        provider: data.provider,
                        related_prompts: data.related_prompts,
                        created_at: new Date().toISOString()
                    });

                } catch (error) {
                    this.messages.push({
                        role: 'assistant',
                        content: 'Error de conexión. Por favor, inténtalo de nuevo.'
                    });
                } finally {
                    this.loading = false;
                    this.$nextTick(() => {
                        this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                    });
                }
            },

            openCreatePromptModal(message) {
                this.newPrompt = {
                    titulo: '',
                    descripcion: '',
                    contenido: message.content
                };
                this.showCreatePromptModal = true;
            },

            async createPrompt() {
                if (!this.newPrompt.titulo || !this.newPrompt.contenido) return;

                this.creatingPrompt = true;

                try {
                    const response = await fetch('{{ route("chatbot.prompt.create") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(this.newPrompt)
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.showCreatePromptModal = false;
                        this.messages.push({
                            role: 'assistant',
                            content: `¡Prompt **"${data.prompt.titulo}"** creado exitosamente! [Ver prompt](${data.url})`
                        });
                        this.$nextTick(() => {
                            this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                        });
                    } else {
                        alert(data.error || 'Error al crear el prompt');
                    }
                } catch (error) {
                    console.error('Error creating prompt:', error);
                    alert('Error de conexión al crear el prompt');
                } finally {
                    this.creatingPrompt = false;
                }
            }
        };
    }
    </script>
    @endpush
</x-app-layout>
