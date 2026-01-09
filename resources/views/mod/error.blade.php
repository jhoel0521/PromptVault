<div id="errorModal" class="modal-overlay">
    <div class="modal-content error">
        <button type="button" class="modal-close" onclick="closeErrorModal()">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="modal-header">
            <div class="modal-icon-wrapper">
                <div class="modal-icon warning pulse-animation">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <!-- BOLD RED HEADER -->
            <h3 style="color: #e11d48; text-shadow: 0 0 15px rgba(225, 29, 72, 0.4);">¡Error del Sistema!</h3>
        </div>

        <div class="modal-body">
            <!-- Tech Message Box -->
            <div class="target-card">
                <div class="target-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="target-details">
                    <span class="target-label">Reporte de Fallo:</span>
                    <h4 id="errorMessage" style="font-family: 'Montserrat', sans-serif;">Ha ocurrido un error inesperado</h4>
                </div>
            </div>
        </div>

        <div class="modal-footer" style="justify-content: center;">
            <button type="button" class="btn-delete-confirm" onclick="closeErrorModal()">
                <span>Cerrar</span>
            </button>
        </div>
    </div>
</div>
