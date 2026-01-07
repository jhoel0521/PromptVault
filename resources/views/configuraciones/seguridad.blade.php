<div class="settings-card">
    <div class="config-header-compact">
        <div class="header-left">
            <i class="fas fa-shield-alt text-red"></i>
            <span>Políticas de Acceso</span>
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
                    <span class="setting-label">Autenticación de Dos Factores (2FA)</span>
                    <span class="setting-desc">Requerir código de verificación para administradores.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="2fa_auth">
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label"><i class="fas fa-stopwatch"></i> Timeout de Sesión (min)</label>
            <input type="number" class="form-input" value="120">
        </div>

        <div class="form-group">
             <label class="form-label"><i class="fas fa-user-lock"></i> Intentos Fallidos</label>
             <select class="form-input form-select">
                <option>3 Intentos</option>
                <option>5 Intentos</option>
                <option>10 Intentos</option>
            </select>
        </div>

        <div class="form-group full-width mt-4">
             <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Bloqueo Geográfico</span>
                    <span class="setting-desc">Permitir acceso solo desde regiones autorizadas (Bolivia).</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="geo_block" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="stat-pill-mini bg-green-900 text-green-400"><i class="fas fa-shield-check"></i> Protegido</span>
            <span style="font-size: 0.8rem; color: #6b7280;">Monitoreo Activo</span>
        </div>
        <button class="btn-submit"><i class="fas fa-save"></i> Guardar Políticas</button>
    </div>
</div>

<div class="settings-card mt-4">
    <div class="config-header-compact">
        <div class="header-left">
            <i class="fas fa-key text-red"></i>
            <span>Seguridad de Contraseñas</span>
        </div>
         <div class="header-right">
             <button class="btn-submit" style="padding: 0.4rem 1rem; font-size: 0.8rem; background: var(--primary-red, #ef4444); border: none; box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);">
                <i class="fas fa-sync-alt"></i> Reset
             </button>
        </div>
    </div>

    <div class="form-grid">
         <div class="form-group">
             <label class="form-label"><i class="fas fa-ruler-horizontal"></i> Longitud Mínima</label>
             <select class="form-input form-select">
                <option>8 Caracteres</option>
                <option selected>12 Caracteres</option>
                <option>16 Caracteres</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label"><i class="fas fa-clock"></i> Expiración (Días)</label>
            <input type="number" class="form-input" value="90">
        </div>

        <div class="form-group full-width mt-4">
             <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Caracteres Especiales</span>
                    <span class="setting-desc">Forzar uso de símbolos (!@#$) y números en contraseñas nuevas.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="special_chars" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

         <div class="form-group full-width mt-4">
             <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Forzar Renovación</span>
                    <span class="setting-desc">Requerir cambio de contraseña en el próximo inicio de sesión.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="force_rotation">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="stat-pill-mini bg-green-900 text-green-400"><i class="fas fa-lock"></i> Encriptado</span>
            <span style="font-size: 0.8rem; color: #6b7280;">Standard AES-256</span>
        </div>
        <button class="btn-submit"><i class="fas fa-save"></i> Guardar Seguridad</button>
    </div>
</div>
