/* ============================================
   LOADING SCREEN JS
   ============================================ */
const LoadingScreen = {
    overlay: null,
    progressBar: null,
    percentageText: null,
    statusText: null,
    progress: 0,
    interval: null,

    // Mensajes contextuales del sistema de transporte
    messages: [
        "Estableciendo conexión segura...",
        "Cargando módulo de conductores...",
        "Sincronizando flota de vehículos...",
        "Verificando rutas y horarios...",
        "Cargando historial de viajes...",
        "Actualizando reportes en tiempo real...",
        "Configurando panel de administración...",
        "Finalizando configuración...",
    ],

    init: function () {
        this.overlay = document.getElementById("loadingOverlay");
        this.progressBar = document.getElementById("loadingProgressBar");
        this.percentageText = document.getElementById("loadingPercentage");
        this.statusText = document.getElementById("loadingStatus");

        // Expose globally
        window.showLoading = this.show.bind(this);
        window.hideLoading = this.hide.bind(this);
        window.simulateLoading = this.simulate.bind(this);
    },

    show: function () {
        if (this.overlay) {
            this.overlay.classList.add("active");
            this.reset();
        }
    },

    hide: function () {
        if (this.overlay) {
            // Fade out
            this.overlay.style.opacity = "0";
            setTimeout(() => {
                this.overlay.classList.remove("active");
                this.overlay.style.opacity = "";
                this.reset();
            }, 500);
        }
    },

    reset: function () {
        this.progress = 0;
        this.updateUI();
        if (this.interval) clearInterval(this.interval);
    },

    updateUI: function () {
        if (this.progressBar)
            this.progressBar.style.width = `${this.progress}%`;
        if (this.percentageText)
            this.percentageText.textContent = `${Math.round(this.progress)}%`;

        // Update status message based on progress
        if (this.statusText) {
            const messageIndex = Math.min(
                Math.floor((this.progress / 100) * this.messages.length),
                this.messages.length - 1
            );
            this.statusText.textContent = this.messages[messageIndex];
        }
    },

    simulate: function (duration = 2500, callback) {
        this.show();
        this.progress = 0;

        const step = 100 / (duration / 20); // Update every 20ms

        this.interval = setInterval(() => {
            this.progress += step;

            // Add some randomness to speed for realism
            if (Math.random() > 0.7) this.progress += step * 0.5;

            if (this.progress >= 100) {
                this.progress = 100;
                this.updateUI();
                clearInterval(this.interval);
                setTimeout(() => {
                    this.hide();
                    if (callback) callback();
                }, 500);
            } else {
                this.updateUI();
            }
        }, 20);
    },
};

document.addEventListener("DOMContentLoaded", () => {
    LoadingScreen.init();

    // Link interception removed to prevent navigation issues
});
