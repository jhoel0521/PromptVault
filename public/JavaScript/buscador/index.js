// ======================================
// BUSCADOR - FUNCIONALIDAD
// ======================================

document.addEventListener('DOMContentLoaded', function() {
    // Elementos
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchQuery');
    const suggestionButtons = document.querySelectorAll('.suggestion-btn');
    
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
    
    // Evento: Limpiar búsqueda con ESC
    if (searchInput) {
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                this.focus();
            }
        });
    }
    
    // Auto-focus en el input al cargar la página
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
    
    // Animación de entrada para resultados
    animateResults();
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
