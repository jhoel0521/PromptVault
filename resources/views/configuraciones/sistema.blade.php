<div class="settings-card">
    <div class="config-header-compact">
        <div class="header-left">
            <i class="fas fa-server text-red"></i>
            <span>Entorno del Servidor</span>
        </div>
        <div class="header-right">
             <button class="btn-submit" style="padding: 0.4rem 1rem; font-size: 0.8rem; background: var(--primary-red, #ef4444); border: none; box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);">
                <i class="fas fa-sync-alt"></i> Reset
             </button>
        </div>
    </div>
    
    <div class="form-grid">
        <div class="form-group">
            <label class="form-label"><i class="fab fa-php"></i> Versión de PHP</label>
            <input type="text" class="form-input" value="{{ phpversion() }}" readonly style="opacity: 0.7;">
        </div>
        
        <div class="form-group">
            <label class="form-label"><i class="fab fa-laravel"></i> Versión de Laravel</label>
            <input type="text" class="form-input" value="{{ app()->version() }}" readonly style="opacity: 0.7;">
        </div>

        <div class="form-group">
             <label class="form-label"><i class="fas fa-hdd"></i> Driver de Caché</label>
             <select class="form-input form-select">
                <option selected>file (Local)</option>
                <option>redis</option>
                <option>memcached</option>
            </select>
        </div>

        <div class="form-group">
             <label class="form-label"><i class="fas fa-cookie"></i> Driver de Sesión</label>
             <select class="form-input form-select">
                <option selected>file (Local)</option>
                <option>database</option>
                <option>cookie</option>
            </select>
        </div>
        
        <div class="form-group full-width mt-4">
             <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Modo Debug (Desarrollo)</span>
                    <span class="setting-desc">Mostrar errores detallados. <strong class="text-red">¡No activar en producción!</strong></span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="debug_mode" {{ config('app.debug') ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="stat-pill-mini bg-green-900 text-green-400"><i class="fas fa-check-double"></i> Estable</span>
            <span style="font-size: 0.8rem; color: #6b7280;">Uptime: 72h</span>
        </div>
        <button class="btn-submit"><i class="fas fa-save"></i> Guardar Entorno</button>
    </div>
</div>

<div class="settings-card mt-4">
    <div class="config-header-compact">
        <div class="header-left">
            <i class="fas fa-tools text-red"></i>
            <span>Diagnóstico y Mantenimiento</span>
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
                    <span class="setting-label">Registro de Errores (Logs)</span>
                    <span class="setting-desc">Guardar historial de excepciones y fallos del sistema.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="logging_enabled" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="form-group">
             <label class="form-label"><i class="fas fa-broom"></i> Limpieza Automática</label>
             <select class="form-input form-select">
                <option>Semanalmente</option>
                <option>Mensualmente</option>
                <option>Nunca</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label"><i class="fas fa-exclamation-triangle"></i> Nivel de Log</label>
             <select class="form-input form-select">
                <option>Error & Critical</option>
                <option>Warning</option>
                <option>Debug (Todo)</option>
            </select>
        </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="stat-pill-mini bg-blue-900 text-blue-400" style="background: rgba(59, 130, 246, 0.2); color: #60a5fa;"><i class="fas fa-clipboard-list"></i> Logs: 0</span>
            <span style="font-size: 0.8rem; color: #6b7280;">Sistema Limpio</span>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button class="btn-submit" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1); box-shadow: none;">
                <i class="fas fa-broom"></i> Limpiar Caché
            </button>
            <button class="btn-submit"><i class="fas fa-rocket"></i> Optimizar</button>
        </div>
    </div>
</div>
