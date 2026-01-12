@auth
<div id="chatbot-widget" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; font-family: 'Inter', sans-serif;">
    <!-- Botón flotante -->
    <button id="chatbot-btn" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #e11d48 0%, #be123c 100%); 
                                     color: #fff; border: none; box-shadow: 0 4px 20px rgba(225, 29, 72, 0.4); cursor: pointer; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
        <i class="fas fa-robot" style="font-size: 24px;"></i>
    </button>
    
    <!-- Ventana chat (oculta) -->
    <div id="chatbot-window" style="display: none; position: absolute; bottom: 80px; right: 0; 
                                     width: 380px; height: 600px; background: #111827; 
                                     border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); 
                                     border: 1px solid rgba(255, 255, 255, 0.1); flex-direction: column; overflow: hidden; transform-origin: bottom right;">
        <!-- Header -->
        <div style="padding: 1.25rem; background: rgba(31, 41, 55, 0.5); border-bottom: 1px solid rgba(255, 255, 255, 0.05); display: flex; justify-content: space-between; align-items: center; backdrop-filter: blur(10px);">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(225, 29, 72, 0.2); display: flex; align-items: center; justify-content: center; color: #e11d48;">
                    <i class="fas fa-brain"></i>
                </div>
                <div>
                    <h4 style="margin: 0; color: #fff; font-size: 1rem; font-weight: 600;">Asistente IA</h4>
                    <small style="color: #9ca3af; font-size: 0.75rem; display: block;">Powered by Groq</small>
                </div>
            </div>
            <button id="chatbot-close" style="width: 32px; height: 32px; border-radius: 8px; background: transparent; border: none; color: #9ca3af; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Messages -->
        <div id="chatbot-messages" style="flex: 1; overflow-y: auto; padding: 1.25rem; display: flex; flex-direction: column; gap: 1rem; scroll-behavior: smooth;">
            <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(225, 29, 72, 0.2); display: flex; align-items: center; justify-content: center; color: #e11d48; flex-shrink: 0; font-size: 0.75rem;">
                    <i class="fas fa-robot"></i>
                </div>
                <div style="padding: 0.85rem 1rem; background: rgba(31, 41, 55, 0.8); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 0 16px 16px 16px; color: #e5e7eb; font-size: 0.95rem; line-height: 1.5; max-width: 85%;">
                    ¡Hola! Soy tu asistente inteligente. Puedo ayudarte a encontrar, mejorar o analizar tus prompts. ¿Qué necesitas hoy?
                </div>
            </div>
        </div>
        
        <!-- Input Area -->
        <div style="padding: 1rem; background: rgba(31, 41, 55, 0.5); border-top: 1px solid rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px);">
            <form id="chatbot-form" style="position: relative;">
                <input type="text" id="chatbot-input" placeholder="Pregunta sobre tus prompts..." 
                       style="width: 100%; padding: 0.85rem 3rem 0.85rem 1rem; background: rgba(17, 24, 39, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); 
                              border-radius: 12px; color: #fff; outline: none; transition: border-color 0.2s; font-size: 0.95rem;">
                <button type="submit" id="chatbot-submit-btn" style="position: absolute; right: 6px; top: 6px; width: 34px; height: 34px; background: #e11d48; color: #fff; border: none; 
                                             border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                    <i class="fas fa-paper-plane" style="font-size: 0.85rem;"></i>
                </button>
            </form>
            <div style="text-align: center; margin-top: 0.5rem;">
                <small style="color: #6b7280; font-size: 0.7rem;">La IA puede cometer errores. Verifica la información importante.</small>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('JavaScript/components/chatbot.js') }}"></script>
@endauth
