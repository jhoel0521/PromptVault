// ======================================
// BUSCADOR - FUNCIONALIDAD CON LIVE SEARCH
// ======================================

document.addEventListener('DOMContentLoaded', function() {
    // Elementos
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchQuery');
    const liveResults = document.getElementById('liveSearchResults');
    const suggestionButtons = document.querySelectorAll('.suggestion-btn');
    
    let searchTimeout = null;
    let currentResults = [];
    
    // Evento: Input en búsqueda (Live Search)
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            
            // Limpiar timeout anterior
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }
            
            // Si está vacío, ocultar resultados
            if (query.length === 0) {
                hideLiveResults();
                return;
            }
            
            // Si tiene menos de 2 caracteres, mostrar mensaje
            if (query.length < 2) {
                showLiveMessage('Escribe al menos 2 caracteres para buscar...');
                return;
            }
            
            // Mostrar loading
            showLiveLoading();
            
            // Debounce: esperar 300ms antes de buscar
            searchTimeout = setTimeout(() => {
                performLiveSearch(query);
            }, 300);
        });
        
        // Cerrar resultados al hacer click fuera
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !liveResults.contains(e.target)) {
                hideLiveResults();
            }
        });
        
        // Cerrar con ESC
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideLiveResults();
                this.blur();
            }
        });
    }
    
    // Evento: Enviar formulario de búsqueda
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const query = searchInput.value.trim();
            
            if (!query) {
                e.preventDefault();
                searchInput.focus();
                showNotification('Por favor ingresa un término de búsqueda', 'warning');
                return;
            }
        });
    }
    
    // Evento: Click en sugerencias
    suggestionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const query = this.getAttribute('data-query');
            if (query && searchInput) {
                searchInput.value = query;
                searchForm.submit();
            }
        });
    });
    
    // Auto-focus en el input al cargar la página
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
    
    // Animación de entrada para resultados
    animateResults();
    
    // ======================================
    // FUNCIONES DE LIVE SEARCH
    // ======================================
    
    async function performLiveSearch(query) {
        try {
            const response = await fetch(`/buscador/search?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            if (data.resultados && data.resultados.length > 0) {
                currentResults = data.resultados;
                showLiveResults(data.resultados);
            } else {
                showNoLiveResults();
            }
        } catch (error) {
            console.error('Error en búsqueda:', error);
            showLiveMessage('Error al buscar. Intenta nuevamente.');
        }
    }
    
    function showLiveResults(resultados) {
        let html = '';
        
        // Agrupar por tipo
        const porTipo = {};
        resultados.forEach(item => {
            if (!porTipo[item.tipo]) {
                porTipo[item.tipo] = [];
            }
            porTipo[item.tipo].push(item);
        });
        
        // Renderizar por tipo
        Object.keys(porTipo).forEach(tipo => {
            html += `<div class="live-search-header"><h5>${tipo}s</h5></div>`;
            
            porTipo[tipo].forEach(item => {
                const iconClass = getIconClass(item.icono);
                html += `
                    <a href="${item.url}" class="live-search-item">
                        <div class="live-search-icon">
                            <i class="fas ${iconClass}"></i>
                        </div>
                        <div class="live-search-content">
                            <div class="live-search-title">${escapeHtml(item.titulo)}</div>
                            <div class="live-search-desc">${escapeHtml(item.descripcion)}</div>
                        </div>
                        <span class="live-search-badge">${item.tipo}</span>
                    </a>
                `;
            });
        });
        
        liveResults.innerHTML = html;
        liveResults.classList.add('active');
    }
    
    function showNoLiveResults() {
        liveResults.innerHTML = `
            <div class="live-search-no-results">
                <i class="fas fa-search"></i>
                <p><strong>No se encontraron resultados</strong></p>
                <p style="font-size: 0.85rem; margin-top: 8px;">
                    Intenta buscar: Dashboard, Prompts, Calendario, Configuraciones
                </p>
            </div>
        `;
        liveResults.classList.add('active');
    }
    
    function showLiveMessage(message) {
        liveResults.innerHTML = `
            <div class="live-search-no-results">
                <i class="fas fa-info-circle"></i>
                <p>${message}</p>
            </div>
        `;
        liveResults.classList.add('active');
    }
    
    function showLiveLoading() {
        liveResults.innerHTML = `
            <div class="live-search-loading">
                <i class="fas fa-spinner"></i>
                <p>Buscando...</p>
            </div>
        `;
        liveResults.classList.add('active');
    }
    
    function hideLiveResults() {
        liveResults.classList.remove('active');
        setTimeout(() => {
            liveResults.innerHTML = '';
        }, 300);
    }
    
    function getIconClass(icon) {
        const iconMap = {
            'file-alt': 'fa-file-alt',
            'folder': 'fa-folder',
            'tag': 'fa-tag',
            'user': 'fa-user',
            'desktop': 'fa-desktop',
            'calendar': 'fa-calendar',
            'cog': 'fa-cog'
        };
        return iconMap[icon] || 'fa-circle';
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});

// ======================================
// FUNCIONES AUXILIARES
// ======================================

/**
 * Animar la aparición de resultados
 */
function animateResults() {
    const resultItems = document.querySelectorAll('.result-item');
    
    resultItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.4s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 50);
    });
}

/**
 * Mostrar notificación
 */
function showNotification(message, type = 'info') {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Estilos inline
    Object.assign(notification.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        padding: '1rem 1.5rem',
        background: type === 'warning' ? '#ff9800' : '#4caf50',
        color: 'white',
        borderRadius: '8px',
        boxShadow: '0 4px 12px rgba(0, 0, 0, 0.2)',
        zIndex: '10000',
        animation: 'slideIn 0.3s ease',
        fontSize: '0.95rem',
        fontWeight: '500'
    });
    
    // Agregar al DOM
    document.body.appendChild(notification);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Agregar estilos de animación
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
