<div id="successModal" class="modal-overlay">
    <div class="modal-content success">
        <button type="button" class="modal-close" onclick="closeSuccessModal()">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="modal-header">
            <div class="modal-icon-wrapper">
                <!-- Using '.modal-icon.warning' style for Red Circle, but keeping check icon -->
                <div class="modal-icon warning pulse-animation-success">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            <!-- BOLD RED HEADER as per user request for emphasis -->
            <h3 style="color: #e11d48; text-shadow: 0 0 15px rgba(225, 29, 72, 0.4);">¡Operación Exitosa!</h3>
            <!-- Added Subtitle for consistency if needed, or just keep header emphasized -->
        </div>

        <div class="modal-body">
            <!-- Tech Message Box - RED THEME -->
            <div class="target-card" style="border-left-color: #e11d48;">
                <div class="target-icon" style="background: rgba(225, 29, 72, 0.1); color: #e11d48; border-color: rgba(225, 29, 72, 0.3);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="target-details">
                    <span class="target-label">Estado del Sistema:</span>
                    <h4 id="successMessage" style="font-family: 'Montserrat', sans-serif;">Acción completada</h4>
                </div>
            </div>
        </div>

        <div class="modal-footer" style="justify-content: center;">
            <button type="button" class="btn-delete-confirm" onclick="closeSuccessModal()">
                <span>Entendido</span>
            </button>
        </div>
    </div>
</div>
