<div class="settings-card">
    <div class="config-header-compact">
        <div class="header-left">
            <i class="fas fa-broadcast-tower text-red"></i>
            <span>Canales de Comunicación</span>
        </div>
        <div class="header-right">
             <button class="btn-submit" style="padding: 0.4rem 1rem; font-size: 0.8rem; background: var(--primary-red, #ef4444); border: none; box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);">
                <i class="fas fa-sync-alt"></i> Reset
             </button>
        </div>
    </div>
    
    <div class="form-grid">
        <div class="form-group full-width">
            <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Notificaciones por Correo</span>
                    <span class="setting-desc">Enviar resúmenes diarios y alertas de seguridad.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="email_notif" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label"><i class="fas fa-envelope-open-text"></i> Email de Destino</label>
            <input type="email" class="form-input" value="admin@tech-home.edu.bo">
        </div>

        <div class="form-group">
             <label class="form-label"><i class="fas fa-bell"></i> Sonido de Alerta</label>
             <select class="form-input form-select">
                <option>Tech Home Chime</option>
                <option>Subtle Ping</option>
                <option>Silencio</option>
            </select>
        </div>

        <div class="form-group full-width mt-4">
             <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Alertas Push (Navegador)</span>
                    <span class="setting-desc">Mostrar pop-ups flotantes mientras se usa el sistema.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="push_notif" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="stat-pill-mini bg-green-900 text-green-400"><i class="fas fa-satellite-dish"></i> En Línea</span>
            <span style="font-size: 0.8rem; color: #6b7280;">SMTP Configurado</span>
        </div>
        <button class="btn-submit"><i class="fas fa-save"></i> Guardar Canales</button>
    </div>
</div>

<div class="settings-card mt-4">
    <div class="config-header-compact">
        <div class="header-left">
            <i class="fas fa-filter text-red"></i>
            <span>Reglas de Alerta</span>
        </div>
         <div class="header-right">
             <button class="btn-submit" style="padding: 0.4rem 1rem; font-size: 0.8rem; background: var(--primary-red, #ef4444); border: none; box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);">
                <i class="fas fa-sync-alt"></i> Reset
             </button>
        </div>
    </div>

    <div class="form-grid">
         <div class="form-group full-width">
             <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Alertas Críticas Solamente</span>
                    <span class="setting-desc">Ignorar notificaciones informativas o de bajo nivel.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="critical_only">
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="form-group">
             <label class="form-label"><i class="fas fa-moon"></i> Horario Silencioso</label>
             <select class="form-input form-select">
                <option>Nunca</option>
                <option>22:00 - 06:00</option>
                <option>Fines de Semana</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label"><i class="fas fa-layer-group"></i> Agrupación</label>
             <select class="form-input form-select">
                <option>Individual</option>
                <option selected>Resumen Diario</option>
                <option>Resumen Semanal</option>
            </select>
        </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="stat-pill-mini bg-blue-900 text-blue-400" style="background: rgba(59, 130, 246, 0.2); color: #60a5fa;"><i class="fas fa-filter"></i> Filtrado</span>
            <span style="font-size: 0.8rem; color: #6b7280;">Inteligente</span>
        </div>
        <button class="btn-submit"><i class="fas fa-save"></i> Guardar Reglas</button>
    </div>
</div>
