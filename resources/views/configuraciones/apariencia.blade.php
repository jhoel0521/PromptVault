<div class="settings-card">
    <div class="config-header-compact">
        <div class="header-left">
            <i class="fas fa-palette text-red"></i>
            <span>Personalización del Tema</span>
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
                    <span class="setting-label">Tema Oscuro "True Black"</span>
                    <span class="setting-desc">Utilizar fondo negro absoluto para pantallas OLED.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="true_black" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label"><i class="fas fa-font"></i> Fuente del Sistema</label>
            <select class="form-input form-select">
                <option>Outfit (Recomendado)</option>
                <option>Inter</option>
                <option>Roboto</option>
            </select>
        </div>

        <div class="form-group">
             <label class="form-label"><i class="fas fa-magic"></i> Intensidad de Neón</label>
             <select class="form-input form-select">
                <option>Sutil</option>
                <option selected>Intenso</option>
                <option>Apagado</option>
            </select>
        </div>

        <div class="form-group full-width mt-4">
             <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Efectos de Transparencia</span>
                    <span class="setting-desc">Habilitar efecto de vidrio molido en tarjetas (Glassmorphism).</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="glass_effect" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="stat-pill-mini bg-green-900 text-green-400"><i class="fas fa-eye"></i> Visualización</span>
            <span style="font-size: 0.8rem; color: #6b7280;">High Contrast</span>
        </div>
        <button class="btn-submit"><i class="fas fa-save"></i> Guardar Apariencia</button>
    </div>
</div>

<div class="settings-card mt-4">
    <div class="config-header-compact">
        <div class="header-left">
            <i class="fas fa-desktop text-red"></i>
            <span>Experiencia de Usuario (UX)</span>
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
                    <span class="setting-label">Animaciones de Interfaz</span>
                    <span class="setting-desc">Suavizar transiciones entre páginas y elementos.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="animations" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="form-group">
             <label class="form-label"><i class="fas fa-compress-arrows-alt"></i> Densidad de Contenido</label>
             <select class="form-input form-select">
                <option>Compacto</option>
                <option selected>Confortable</option>
                <option>Amplio</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label"><i class="fas fa-columns"></i> Sidebar Inicial</label>
             <select class="form-input form-select">
                <option>Expandido</option>
                <option>Colapsado</option>
            </select>
        </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="stat-pill-mini bg-green-900 text-green-400"><i class="fas fa-bolt"></i> Rendimiento</span>
            <span style="font-size: 0.8rem; color: #6b7280;">60 FPS</span>
        </div>
        <button class="btn-submit"><i class="fas fa-save"></i> Guardar Preferencias</button>
    </div>
</div>
