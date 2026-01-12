document.addEventListener("DOMContentLoaded", function () {
    const widget = document.getElementById("chatbot-widget");
    if (!widget) return;

    const btn = document.getElementById("chatbot-btn");
    const window = document.getElementById("chatbot-window");
    const close = document.getElementById("chatbot-close");
    const form = document.getElementById("chatbot-form");
    const input = document.getElementById("chatbot-input");
    const messages = document.getElementById("chatbot-messages");

    // Toggle state
    let isOpen = false;

    // Toggle window function
    function toggleChat() {
        isOpen = !isOpen;
        if (isOpen) {
            window.style.display = "flex";
            // Simple animation
            window.style.opacity = "0";
            window.style.transform = "scale(0.9) translateY(20px)";
            setTimeout(() => {
                window.style.opacity = "1";
                window.style.transform = "scale(1) translateY(0)";
                window.style.transition =
                    "all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)";
            }, 10);
            input.focus();
        } else {
            window.style.opacity = "0";
            window.style.transform = "scale(0.9) translateY(20px)";
            setTimeout(() => {
                window.style.display = "none";
            }, 300);
        }
    }

    btn.addEventListener("click", toggleChat);
    close.addEventListener("click", toggleChat);

    // Submit form
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const question = input.value.trim();
        if (!question) return;

        // Add user message
        addMessage(question, "user");
        input.value = "";

        // Disable input while loading
        input.disabled = true;
        const loadingId = addMessage("Analizando...", "bot", true);

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');

            const response = await fetch("/chatbot/ask", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken ? csrfToken.content : "",
                },
                body: JSON.stringify({ question }),
            });

            const data = await response.json();

            // Remove loading
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) loadingEl.remove();

            // Enable input
            input.disabled = false;
            input.focus();

            if (data.error) {
                addMessage(data.error, "bot");
            } else {
                // Typewriter effect for response
                const msgId = addMessage("", "bot");
                typeWriter(data.response, msgId, () => {
                    // Show related prompts after typing matches
                    if (
                        data.related_prompts &&
                        data.related_prompts.length > 0
                    ) {
                        addRelatedPrompts(data.related_prompts);
                    }
                });
            }
        } catch (error) {
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) loadingEl.remove();
            input.disabled = false;
            addMessage(
                "Error de conexión. Por favor verifica tu internet e intenta de nuevo.",
                "bot"
            );
            console.error(error);
        }
    });

    function addMessage(text, type, loading = false) {
        const id =
            "msg-" + Date.now() + Math.random().toString(36).substr(2, 9);
        const div = document.createElement("div");
        div.id = id;

        if (type === "user") {
            div.style.cssText = `
                align-self: flex-end;
                padding: 0.85rem 1rem;
                background: #e11d48;
                color: #fff;
                border-radius: 16px 16px 0 16px;
                font-size: 0.95rem;
                line-height: 1.5;
                max-width: 85%;
                box-shadow: 0 4px 12px rgba(225, 29, 72, 0.2);
                margin-left: auto;
            `;
            div.textContent = text;
        } else {
            div.style.cssText = `
                display: flex;
                gap: 0.75rem;
                align-items: flex-start;
                max-width: 90%;
            `;

            const content = loading
                ? `<div style="display: flex; gap: 4px; align-items: center; height: 24px;">
                    <span style="width: 6px; height: 6px; background: #e11d48; border-radius: 50%; display: inline-block; animation: bounce 1.4s infinite ease-in-out both;"></span>
                    <span style="width: 6px; height: 6px; background: #e11d48; border-radius: 50%; display: inline-block; animation: bounce 1.4s infinite ease-in-out both; animation-delay: -0.32s;"></span>
                    <span style="width: 6px; height: 6px; background: #e11d48; border-radius: 50%; display: inline-block; animation: bounce 1.4s infinite ease-in-out both; animation-delay: -0.16s;"></span>
                 </div>`
                : text;

            div.innerHTML = `
                <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(225, 29, 72, 0.2); display: flex; align-items: center; justify-content: center; color: #e11d48; flex-shrink: 0; font-size: 0.75rem;">
                    <i class="fas fa-robot"></i>
                </div>
                <div id="${id}-content" style="padding: 0.85rem 1rem; background: rgba(31, 41, 55, 0.8); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 0 16px 16px 16px; color: #e5e7eb; font-size: 0.95rem; line-height: 1.5;">
                    ${content}
                </div>
            `;
        }

        messages.appendChild(div);
        scrollToBottom();
        return id;
    }

    function scrollToBottom() {
        messages.scrollTo({
            top: messages.scrollHeight,
            behavior: "smooth",
        });
    }

    function typeWriter(text, msgId, callback) {
        let i = 0;
        const element = document.getElementById(msgId + "-content");
        if (!element) return;

        // Formato markdown simple (negrita)
        const formattedText = text.replace(
            /\*\*(.*?)\*\*/g,
            "<strong>$1</strong>"
        );
        // Convertir saltos de línea
        const htmlText = formattedText.replace(/\n/g, "<br>");

        element.innerHTML = htmlText; // Renderizar directo por ahora para soportar HTML

        if (callback) callback();
        scrollToBottom();
    }

    function addRelatedPrompts(prompts) {
        const div = document.createElement("div");
        div.style.cssText = `
            margin-left: 40px;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: -0.5rem;
        `;

        prompts.forEach((p) => {
            const link = document.createElement("a");
            link.href = p.url;
            link.target = "_blank";
            link.style.cssText = `
                display: block;
                padding: 0.75rem;
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.05);
                border-radius: 12px;
                text-decoration: none;
                transition: background 0.2s;
            `;

            link.innerHTML = `
                <div style="font-weight: 600; color: #e11d48; font-size: 0.9rem; margin-bottom: 0.25rem;">
                    <i class="fas fa-link" style="font-size: 0.75rem; margin-right: 0.25rem;"></i> ${
                        p.titulo
                    }
                </div>
                <div style="color: #9ca3af; font-size: 0.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    ${p.descripcion || "Sin descripción"}
                </div>
            `;

            link.addEventListener(
                "mouseenter",
                () => (link.style.background = "rgba(255, 255, 255, 0.08)")
            );
            link.addEventListener(
                "mouseleave",
                () => (link.style.background = "rgba(255, 255, 255, 0.03)")
            );

            div.appendChild(link);
        });

        messages.appendChild(div);
        scrollToBottom();
    }

    // Add bounce animation style
    const style = document.createElement("style");
    style.innerHTML = `
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    `;
    document.head.appendChild(style);
});
