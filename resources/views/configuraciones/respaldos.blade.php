<div class="settings-card">
    <div class="config-header-compact">
        <div class="header-left">
            <i class="fas fa-database text-red"></i>
            <span>Estrategia de Respaldo</span>
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
                    <span class="setting-label">Respaldos Automáticos</span>
                    <span class="setting-desc">Generar copias de la base de datos sin intervención manual.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="auto_backup" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label"><i class="fas fa-clock"></i> Frecuencia</label>
            <select class="form-input form-select">
                <option>Cada 6 Horas</option>
                <option selected>Diario (00:00)</option>
                <option>Semanal (Domingo)</option>
            </select>
        </div>

        <div class="form-group">
             <label class="form-label"><i class="fas fa-history"></i> Retención Local</label>
             <select class="form-input form-select">
                <option>Últimos 7 días</option>
                <option>Últimos 30 días</option>
                <option>Indefinido</option>
            </select>
        </div>

        <div class="form-group full-width mt-4">
             <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Incluir Archivos Multimedia</span>
                    <span class="setting-desc">Respaldar imágenes y documentos subidos (aumenta el tamaño).</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="include_media">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="stat-pill-mini bg-green-900 text-green-400"><i class="fas fa-calendar-check"></i> Programado</span>
            <span style="font-size: 0.8rem; color: #6b7280;">Próximo: 00:00</span>
        </div>
        <button class="btn-submit"><i class="fas fa-save"></i> Guardar Estrategia</button>
    </div>
</div>

<div class="settings-card mt-4">
    <div class="config-header-compact">
        <div class="header-left">
            <i class="fas fa-cloud-upload-alt text-red"></i>
            <span>Almacenamiento en la Nube</span>
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
                    <span class="setting-label">Sincronización Cloud</span>
                    <span class="setting-desc">Subir copias automáticamente a un proveedor externo.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="cloud_sync" checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="form-group">
             <label class="form-label"><i class="fas fa-server"></i> Proveedor</label>
             <select class="form-input form-select">
                <option>Amazon S3</option>
                <option>Google Drive</option>
                <option>Dropbox</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label"><i class="fas fa-folder-open"></i> Ruta Remota</label>
             <input type="text" class="form-input" value="/backups/tech-home/">
        </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="stat-pill-mini bg-green-900 text-green-400"><i class="fas fa-link"></i> Conectado</span>
            <span style="font-size: 0.8rem; color: #6b7280;">API OK</span>
        </div>
        <button class="btn-submit"><i class="fas fa-bolt"></i> Ejecutar Backup Ahora</button>
    </div>
</div>
