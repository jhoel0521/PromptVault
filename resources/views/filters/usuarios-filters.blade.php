<!-- Advanced Filters Modal -->
<div class="filters-modal-overlay" id="filtersModal">
    <div class="filters-modal">
        <div class="filters-header">
            <h3 class="filters-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
                Filtros Avanzados
            </h3>
            <button class="filters-close-btn" id="closeFiltersModal">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="filtersForm" class="filters-content">
            <!-- Filtros principales -->
            <div class="filters-section">
                <h4 class="section-title">Estado y Rol</h4>
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">Estado del Usuario</label>
                        <select name="estado" class="filter-select">
                            <option value="">Todos los estados</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="suspendido">Suspendido</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Rol</label>
                        <select name="rol" class="filter-select">
                            <option value="">Todos los roles</option>
                            <option value="administrador">Administrador</option>
                            <option value="operador">Operador</option>
                            <option value="usuario">Usuario</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Filtros de fecha -->
            <div class="filters-section">
                <h4 class="section-title">Fechas</h4>
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">Registrado desde</label>
                        <input type="date" name="fecha_desde" class="filter-input">
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Registrado hasta</label>
                        <input type="date" name="fecha_hasta" class="filter-input">
                    </div>
                </div>
            </div>

            <!-- Indicadores de filtros activos -->
            <div class="active-filters" id="activeFilters">
                <h4 class="section-title">Filtros Activos <span class="filters-count" id="filtersCount">0</span></h4>
                <div class="active-filters-list" id="activeFiltersList">
                    <!-- Filtros activos aparecerán aquí dinámicamente -->
                </div>
            </div>
        </form>

        <div class="filters-actions">
            <button type="button" class="btn-secondary" id="clearFiltersBtn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
                Limpiar Filtros
            </button>
            <button type="button" class="btn-primary" id="applyFiltersBtn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Aplicar Filtros
            </button>
        </div>
    </div>
</div>
