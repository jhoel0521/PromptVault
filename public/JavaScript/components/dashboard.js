/**
 * PRIMERO DE JUNIO - DASHBOARD JAVASCRIPT PROFESIONAL
 * Sistema de dashboard administrativo optimizado - Basado en el sitio web
 */

class DashboardManager {
  constructor() {
    this.dashboard = null;
    this.statsCards = [];
    this.charts = {};
    this.refreshInterval = null;
    this.isRefreshing = false;
    this.widgets = new Map();
    this.filters = {
      dateRange: '7d',
      status: 'all',
      type: 'all'
    };
    this.websocket = null;
    this.notifications = [];

    this.init();
  }

  init() {
    this.bindElements();
    this.bindEvents();
    this.setupStatsCards();
    this.setupCharts();
    this.setupFilters();
    this.setupRealTimeUpdates();
    this.setupQuickActions();
    this.loadInitialData();
    this.setupAutoRefresh();
    
    console.log('📊 DASHBOARD: Sistema de dashboard inicializado correctamente');
  }

  bindElements() {
    this.dashboard = document.querySelector('.dashboard-container');
    this.statsCards = Array.from(document.querySelectorAll('.stats-card'));
    this.refreshBtn = document.querySelector('.refresh-btn');
    this.filterContainer = document.querySelector('.dashboard-filters');
    this.quickActions = document.querySelector('.quick-actions');
    this.notificationPanel = document.querySelector('.notification-panel');
  }

  bindEvents() {
    // Refresh button
    if (this.refreshBtn) {
      this.refreshBtn.addEventListener('click', this.refreshDashboard.bind(this));
    }

    // Filter changes
    this.setupFilterEvents();

    // Quick action buttons
    this.setupQuickActionEvents();

    // Window events
    window.addEventListener('resize', this.throttle(this.handleResize.bind(this), 250));
    window.addEventListener('focus', this.handleWindowFocus.bind(this));
    window.addEventListener('blur', this.handleWindowBlur.bind(this));

    // Visibility change
    document.addEventListener('visibilitychange', this.handleVisibilityChange.bind(this));

    // Keyboard shortcuts
    this.setupKeyboardShortcuts();
  }

  setupStatsCards() {
    this.statsCards.forEach((card, index) => {
      // Add click functionality for expandable cards
      const header = card.querySelector('.stats-header');
      if (header) {
        header.addEventListener('click', () => this.toggleCardDetails(card, index));
      }

      // Add hover effects
      card.addEventListener('mouseenter', () => this.onCardHover(card));
      card.addEventListener('mouseleave', () => this.onCardLeave(card));

      // Setup card-specific functionality
      this.setupCardFeatures(card, index);
    });
  }

  setupCardFeatures(card, index) {
    const cardType = card.dataset.cardType;
    
    switch (cardType) {
      case 'revenue':
        this.setupRevenueCard(card);
        break;
      case 'trips':
        this.setupTripsCard(card);
        break;
      case 'users':
        this.setupUsersCard(card);
        break;
      case 'vehicles':
        this.setupVehiclesCard(card);
        break;
    }
  }

  setupRevenueCard(card) {
    const trendChart = card.querySelector('.trend-chart');
    if (trendChart) {
      this.createMiniChart(trendChart, 'revenue');
    }
  }

  setupTripsCard(card) {
    const statusIndicators = card.querySelectorAll('.status-indicator');
    statusIndicators.forEach(indicator => {
      indicator.addEventListener('click', (e) => {
        e.stopPropagation();
        this.filterByStatus(indicator.dataset.status);
      });
    });
  }

  setupUsersCard(card) {
    const userTypeChart = card.querySelector('.user-type-chart');
    if (userTypeChart) {
      this.createMiniChart(userTypeChart, 'users');
    }
  }

  setupVehiclesCard(card) {
    const vehicleStatus = card.querySelector('.vehicle-status');
    if (vehicleStatus) {
      this.updateVehicleStatus(vehicleStatus);
    }
  }

  createMiniChart(container, type) {
    const canvas = document.createElement('canvas');
    canvas.width = container.offsetWidth;
    canvas.height = container.offsetHeight;
    container.appendChild(canvas);
    
    const ctx = canvas.getContext('2d');
    
    // Simple sparkline chart
    const data = this.getMockData(type);
    this.drawSparkline(ctx, data, canvas.width, canvas.height);
    
    // Store chart reference
    this.charts[type] = { ctx, canvas, container, data };
  }

  drawSparkline(ctx, data, width, height) {
    if (!data || data.length < 2) return;
    
    const max = Math.max(...data);
    const min = Math.min(...data);
    const range = max - min || 1;
    
    ctx.strokeStyle = '#00ff66';
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    
    ctx.beginPath();
    
    data.forEach((value, index) => {
      const x = (index / (data.length - 1)) * width;
      const y = height - ((value - min) / range) * height;
      
      if (index === 0) {
        ctx.moveTo(x, y);
      } else {
        ctx.lineTo(x, y);
      }
    });
    
    ctx.stroke();
    
    // Add gradient fill
    ctx.globalAlpha = 0.1;
    ctx.fillStyle = '#00ff66';
    ctx.lineTo(width, height);
    ctx.lineTo(0, height);
    ctx.closePath();
    ctx.fill();
  }

  getMockData(type) {
    const baseData = {
      revenue: [100, 120, 115, 130, 125, 140, 135, 150],
      users: [50, 55, 52, 60, 58, 65, 62, 70],
      trips: [30, 35, 32, 40, 38, 42, 45, 48],
      vehicles: [20, 22, 21, 25, 24, 26, 28, 30]
    };
    
    return baseData[type] || [];
  }

  toggleCardDetails(card, index) {
    const details = card.querySelector('.card-details');
    if (details) {
      const isExpanded = card.classList.contains('expanded');
      
      // Collapse all other cards
      this.statsCards.forEach((otherCard, otherIndex) => {
        if (otherIndex !== index) {
          otherCard.classList.remove('expanded');
        }
      });
      
      if (isExpanded) {
        card.classList.remove('expanded');
      } else {
        card.classList.add('expanded');
        this.loadCardDetails(card, index);
      }
    }
  }

  loadCardDetails(card, index) {
    const details = card.querySelector('.card-details');
    if (details && !details.dataset.loaded) {
      // Simulate loading
      details.innerHTML = '<div class="loading-spinner">Cargando...</div>';
      
      setTimeout(() => {
        details.innerHTML = this.getCardDetailsContent(card.dataset.cardType);
        details.dataset.loaded = 'true';
      }, 500);
    }
  }

  getCardDetailsContent(cardType) {
    const content = {
      revenue: `
        <div class="detail-item">
          <span class="detail-label">Ingresos de hoy:</span>
          <span class="detail-value">$2,450,000</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Promedio diario:</span>
          <span class="detail-value">$1,850,000</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Meta mensual:</span>
          <span class="detail-value detail-progress">
            <span class="progress-bar">
              <span class="progress-fill" style="width: 68%"></span>
            </span>
            68%
          </span>
        </div>
      `,
      trips: `
        <div class="detail-item">
          <span class="detail-label">Viajes completados:</span>
          <span class="detail-value">145</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">En progreso:</span>
          <span class="detail-value">23</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Promedio por hora:</span>
          <span class="detail-value">12.5</span>
        </div>
      `,
      users: `
        <div class="detail-item">
          <span class="detail-label">Nuevos usuarios hoy:</span>
          <span class="detail-value">18</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Usuarios activos:</span>
          <span class="detail-value">1,234</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Tasa de retención:</span>
          <span class="detail-value">85%</span>
        </div>
      `,
      vehicles: `
        <div class="detail-item">
          <span class="detail-label">En servicio:</span>
          <span class="detail-value">156</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">En mantenimiento:</span>
          <span class="detail-value">12</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Disponibles:</span>
          <span class="detail-value">32</span>
        </div>
      `
    };
    
    return content[cardType] || '<p>Información no disponible</p>';
  }

  onCardHover(card) {
    card.style.transform = 'translateY(-2px)';
    card.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.15)';
  }

  onCardLeave(card) {
    if (!card.classList.contains('expanded')) {
      card.style.transform = 'translateY(0)';
      card.style.boxShadow = '';
    }
  }

  setupCharts() {
    this.setupMainChart();
    this.setupSecondaryCharts();
  }

  setupMainChart() {
    const mainChartContainer = document.querySelector('.main-chart');
    if (mainChartContainer) {
      // Create main dashboard chart
      this.createMainChart(mainChartContainer);
    }
  }

  createMainChart(container) {
    const canvas = document.createElement('canvas');
    container.appendChild(canvas);
    
    const ctx = canvas.getContext('2d');
    
    // Mock chart data
    const chartData = {
      labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
      datasets: [
        {
          label: 'Ingresos',
          data: [2100000, 2300000, 2800000, 2500000, 3200000, 2900000, 2700000],
          borderColor: '#00ff66',
          backgroundColor: 'rgba(0, 255, 102, 0.1)',
          tension: 0.4
        },
        {
          label: 'Viajes',
          data: [145, 167, 189, 156, 203, 178, 165],
          borderColor: '#ff6b6b',
          backgroundColor: 'rgba(255, 107, 107, 0.1)',
          tension: 0.4
        }
      ]
    };
    
    this.drawMainChart(ctx, chartData);
    this.charts.main = { ctx, canvas, container, data: chartData };
  }

  drawMainChart(ctx, data) {
    // This is a simplified chart drawing
    // In a real application, you'd use Chart.js or similar library
    console.log('📊 Gráfico principal actualizado');
  }

  setupSecondaryCharts() {
    const secondaryCharts = document.querySelectorAll('.secondary-chart');
    secondaryCharts.forEach((chart, index) => {
      this.createSecondaryChart(chart, index);
    });
  }

  createSecondaryChart(container, index) {
    const canvas = document.createElement('canvas');
    container.appendChild(canvas);
    
    const ctx = canvas.getContext('2d');
    const type = container.dataset.chartType || 'doughnut';
    
    // Create different chart types
    this.drawSecondaryChart(ctx, type, index);
    this.charts[`secondary_${index}`] = { ctx, canvas, container, type };
  }

  drawSecondaryChart(ctx, type, index) {
    // Simplified chart drawing based on type
    console.log(`📈 Gráfico secundario ${index} (${type}) actualizado`);
  }

  setupFilters() {
    const filterSelects = document.querySelectorAll('.dashboard-filter');
    filterSelects.forEach(select => {
      select.addEventListener('change', this.handleFilterChange.bind(this));
    });
    
    // Date range picker
    const dateRangePicker = document.querySelector('.date-range-picker');
    if (dateRangePicker) {
      this.setupDateRangePicker(dateRangePicker);
    }
  }

  setupFilterEvents() {
    // Filter buttons
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        // Remove active class from all buttons
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        const filterType = btn.dataset.filter;
        const filterValue = btn.dataset.value;
        this.updateFilter(filterType, filterValue);
      });
    });
  }

  setupDateRangePicker(picker) {
    // Simple date range implementation
    picker.addEventListener('change', (e) => {
      this.filters.dateRange = e.target.value;
      this.applyFilters();
    });
  }

  handleFilterChange(e) {
    const filterType = e.target.dataset.filter;
    const filterValue = e.target.value;
    this.updateFilter(filterType, filterValue);
  }

  updateFilter(type, value) {
    this.filters[type] = value;
    this.applyFilters();
  }

  applyFilters() {
    console.log('🔍 Aplicando filtros:', this.filters);
    
    // Show loading state
    this.showFilteringLoading();
    
    // Apply filters to all dashboard components
    setTimeout(() => {
      this.refreshDashboardData();
      this.hideFilteringLoading();
    }, 500);
  }

  showFilteringLoading() {
    const loadingOverlay = document.querySelector('.filtering-overlay');
    if (loadingOverlay) {
      loadingOverlay.classList.add('show');
    }
  }

  hideFilteringLoading() {
    const loadingOverlay = document.querySelector('.filtering-overlay');
    if (loadingOverlay) {
      loadingOverlay.classList.remove('show');
    }
  }

  filterByStatus(status) {
    this.updateFilter('status', status);
    this.highlightStatusFilter(status);
  }

  highlightStatusFilter(status) {
    const statusBtns = document.querySelectorAll('[data-status]');
    statusBtns.forEach(btn => {
      btn.classList.toggle('active', btn.dataset.status === status);
    });
  }

  setupQuickActions() {
    const actionBtns = document.querySelectorAll('.quick-action-btn');
    actionBtns.forEach(btn => {
      btn.addEventListener('click', this.handleQuickAction.bind(this, btn));
    });
  }

  setupQuickActionEvents() {
    // Specific quick action implementations
    this.setupExportAction();
    this.setupCreateAction();
    this.setupReportAction();
    this.setupSettingsAction();
  }

  setupExportAction() {
    const exportBtn = document.querySelector('[data-action="export"]');
    if (exportBtn) {
      exportBtn.addEventListener('click', () => {
        this.showExportModal();
      });
    }
  }

  setupCreateAction() {
    const createBtn = document.querySelector('[data-action="create"]');
    if (createBtn) {
      createBtn.addEventListener('click', () => {
        this.showCreateModal();
      });
    }
  }

  setupReportAction() {
    const reportBtn = document.querySelector('[data-action="report"]');
    if (reportBtn) {
      reportBtn.addEventListener('click', () => {
        this.generateReport();
      });
    }
  }

  setupSettingsAction() {
    const settingsBtn = document.querySelector('[data-action="settings"]');
    if (settingsBtn) {
      settingsBtn.addEventListener('click', () => {
        this.openDashboardSettings();
      });
    }
  }

  handleQuickAction(btn) {
    const action = btn.dataset.action;
    const actionText = btn.textContent.trim();
    
    // Add loading state
    btn.classList.add('loading');
    btn.disabled = true;
    
    // Simulate action
    setTimeout(() => {
      btn.classList.remove('loading');
      btn.disabled = false;
      this.showActionSuccess(actionText);
    }, 1000);
    
    console.log(`⚡ Acción rápida: ${action}`);
  }

  showActionSuccess(actionText) {
    const toast = document.createElement('div');
    toast.className = 'action-toast success';
    toast.innerHTML = `
      <div class="toast-icon">✅</div>
      <div class="toast-message">${actionText} completado exitosamente</div>
    `;
    
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 300);
    }, 3000);
  }

  showExportModal() {
    console.log('📁 Abriendo modal de exportación');
    // Implementation for export modal
  }

  showCreateModal() {
    console.log('➕ Abriendo modal de creación');
    // Implementation for create modal
  }

  generateReport() {
    console.log('📊 Generando reporte');
    // Implementation for report generation
  }

  openDashboardSettings() {
    console.log('⚙️ Abriendo configuración del dashboard');
    // Implementation for settings modal
  }

  setupRealTimeUpdates() {
    // WebSocket connection for real-time updates
    this.connectWebSocket();
    
    // Fallback to polling if WebSocket not available
    if (!this.websocket) {
      this.setupPolling();
    }
  }

  connectWebSocket() {
    try {
      this.websocket = new WebSocket('wss://localhost:8080/dashboard');
      
      this.websocket.onopen = () => {
        console.log('🔌 WebSocket conectado');
      };
      
      this.websocket.onmessage = (event) => {
        const data = JSON.parse(event.data);
        this.handleRealTimeUpdate(data);
      };
      
      this.websocket.onclose = () => {
        console.log('🔌 WebSocket desconectado');
        this.setupPolling(); // Fallback to polling
      };
      
      this.websocket.onerror = () => {
        console.log('❌ Error en WebSocket');
        this.websocket = null;
        this.setupPolling();
      };
    } catch (error) {
      console.log('WebSocket no disponible, usando polling');
      this.setupPolling();
    }
  }

  setupPolling() {
    // Poll for updates every 30 seconds
    this.refreshInterval = setInterval(() => {
      if (!document.hidden && !this.isRefreshing) {
        this.refreshDashboardData();
      }
    }, 30000);
  }

  handleRealTimeUpdate(data) {
    switch (data.type) {
      case 'stats_update':
        this.updateStatsCards(data.stats);
        break;
      case 'new_notification':
        this.addNotification(data.notification);
        break;
      case 'chart_update':
        this.updateCharts(data.chartData);
        break;
    }
  }

  updateStatsCards(stats) {
    Object.keys(stats).forEach(key => {
      const card = document.querySelector(`[data-card-type="${key}"]`);
      if (card) {
        const valueElement = card.querySelector('.stats-value');
        if (valueElement) {
          this.animateValue(valueElement, stats[key]);
        }
      }
    });
  }

  animateValue(element, newValue) {
    const currentValue = parseInt(element.textContent.replace(/[^\d]/g, ''));
    const duration = 1000;
    const startTime = performance.now();
    
    const animate = (currentTime) => {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      
      const value = Math.floor(currentValue + (newValue - currentValue) * progress);
      element.textContent = this.formatValue(value);
      
      if (progress < 1) {
        requestAnimationFrame(animate);
      }
    };
    
    requestAnimationFrame(animate);
  }

  formatValue(value) {
    if (value >= 1000000) {
      return (value / 1000000).toFixed(1) + 'M';
    } else if (value >= 1000) {
      return (value / 1000).toFixed(1) + 'K';
    }
    return value.toLocaleString();
  }

  addNotification(notification) {
    this.notifications.unshift(notification);
    this.updateNotificationPanel();
    this.showNotificationToast(notification);
  }

  updateNotificationPanel() {
    if (this.notificationPanel) {
      // Update notification count
      const count = this.notificationPanel.querySelector('.notification-count');
      if (count) {
        count.textContent = this.notifications.length;
        count.style.display = this.notifications.length > 0 ? 'block' : 'none';
      }
    }
  }

  showNotificationToast(notification) {
    const toast = document.createElement('div');
    toast.className = `notification-toast ${notification.type}`;
    toast.innerHTML = `
      <div class="toast-content">
        <div class="toast-title">${notification.title}</div>
        <div class="toast-message">${notification.message}</div>
      </div>
    `;
    
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 300);
    }, 5000);
  }

  updateCharts(chartData) {
    Object.keys(chartData).forEach(chartId => {
      if (this.charts[chartId]) {
        // Update chart data and redraw
        this.charts[chartId].data = chartData[chartId];
        this.redrawChart(chartId);
      }
    });
  }

  redrawChart(chartId) {
    const chart = this.charts[chartId];
    if (chart) {
      // Clear canvas
      chart.ctx.clearRect(0, 0, chart.canvas.width, chart.canvas.height);
      
      // Redraw with new data
      if (chartId === 'main') {
        this.drawMainChart(chart.ctx, chart.data);
      } else if (chartId.includes('secondary')) {
        const index = parseInt(chartId.split('_')[1]);
        this.drawSecondaryChart(chart.ctx, chart.type, index);
      } else {
        this.drawSparkline(chart.ctx, chart.data, chart.canvas.width, chart.canvas.height);
      }
    }
  }

  setupAutoRefresh() {
    // Auto-refresh every 5 minutes
    setInterval(() => {
      if (!document.hidden) {
        this.refreshDashboard();
      }
    }, 300000);
  }

  refreshDashboard() {
    if (this.isRefreshing) return;
    
    this.isRefreshing = true;
    this.showRefreshIndicator();
    
    // Simulate data refresh
    setTimeout(() => {
      this.refreshDashboardData();
      this.hideRefreshIndicator();
      this.isRefreshing = false;
      this.updateLastRefreshTime();
    }, 1000);
    
    console.log('🔄 Dashboard actualizado');
  }

  refreshDashboardData() {
    // Refresh all dashboard components
    this.loadStatsData();
    this.loadChartData();
    this.loadRecentActivity();
    this.loadNotifications();
  }

  loadStatsData() {
    // Mock stats data loading
    const mockStats = {
      revenue: Math.floor(Math.random() * 1000000) + 2000000,
      trips: Math.floor(Math.random() * 100) + 200,
      users: Math.floor(Math.random() * 500) + 1500,
      vehicles: Math.floor(Math.random() * 50) + 150
    };
    
    this.updateStatsCards(mockStats);
  }

  loadChartData() {
    // Mock chart data loading
    const mockChartData = {
      main: {
        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
        datasets: [
          {
            data: Array.from({length: 7}, () => Math.floor(Math.random() * 1000000) + 2000000)
          }
        ]
      }
    };
    
    this.updateCharts(mockChartData);
  }

  loadRecentActivity() {
    // Mock recent activity loading
    console.log('📝 Cargando actividad reciente');
  }

  loadNotifications() {
    // Mock notifications loading
    console.log('🔔 Cargando notificaciones');
  }

  loadInitialData() {
    this.loadStatsData();
    this.loadChartData();
    this.loadRecentActivity();
    this.loadNotifications();
  }

  showRefreshIndicator() {
    if (this.refreshBtn) {
      this.refreshBtn.classList.add('refreshing');
      this.refreshBtn.disabled = true;
    }
    
    // Show global refresh indicator
    const indicator = document.querySelector('.refresh-indicator');
    if (indicator) {
      indicator.classList.add('show');
    }
  }

  hideRefreshIndicator() {
    if (this.refreshBtn) {
      this.refreshBtn.classList.remove('refreshing');
      this.refreshBtn.disabled = false;
    }
    
    // Hide global refresh indicator
    const indicator = document.querySelector('.refresh-indicator');
    if (indicator) {
      indicator.classList.remove('show');
    }
  }

  updateLastRefreshTime() {
    const timeElement = document.querySelector('.last-refresh-time');
    if (timeElement) {
      const now = new Date();
      timeElement.textContent = `Última actualización: ${now.toLocaleTimeString()}`;
    }
  }

  handleResize() {
    // Resize charts
    Object.keys(this.charts).forEach(chartId => {
      const chart = this.charts[chartId];
      if (chart && chart.canvas) {
        chart.canvas.width = chart.container.offsetWidth;
        chart.canvas.height = chart.container.offsetHeight;
        this.redrawChart(chartId);
      }
    });
  }

  handleWindowFocus() {
    // Refresh data when window regains focus
    if (!this.isRefreshing) {
      this.refreshDashboard();
    }
  }

  handleWindowBlur() {
    // Pause any ongoing animations or intensive operations
    console.log('⏸️ Dashboard pausado (ventana sin foco)');
  }

  handleVisibilityChange() {
    if (document.hidden) {
      // Pause operations
      if (this.refreshInterval) {
        clearInterval(this.refreshInterval);
      }
    } else {
      // Resume operations
      this.setupAutoRefresh();
      this.refreshDashboard();
    }
  }

  setupKeyboardShortcuts() {
    document.addEventListener('keydown', (e) => {
      // Ctrl/Cmd + R for refresh
      if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        this.refreshDashboard();
      }
      
      // F5 for full refresh
      if (e.key === 'F5') {
        e.preventDefault();
        window.location.reload();
      }
      
      // Ctrl/Cmd + E for export
      if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
        e.preventDefault();
        this.showExportModal();
      }
    });
  }

  // Utility functions
  throttle(func, limit) {
    let inThrottle;
    return function() {
      const args = arguments;
      const context = this;
      if (!inThrottle) {
        func.apply(context, args);
        inThrottle = true;
        setTimeout(() => inThrottle = false, limit);
      }
    };
  }

  // Public API methods
  addWidget(config) {
    const widget = this.createWidget(config);
    this.widgets.set(config.id, widget);
    return widget;
  }

  removeWidget(id) {
    const widget = this.widgets.get(id);
    if (widget) {
      widget.remove();
      this.widgets.delete(id);
    }
  }

  updateWidget(id, data) {
    const widget = this.widgets.get(id);
    if (widget) {
      widget.update(data);
    }
  }

  createWidget(config) {
    const widget = document.createElement('div');
    widget.className = 'dashboard-widget';
    widget.dataset.widgetId = config.id;
    widget.innerHTML = config.content;
    
    const widgetContainer = document.querySelector('.widgets-container');
    if (widgetContainer) {
      widgetContainer.appendChild(widget);
    }
    
    return {
      element: widget,
      update: (data) => {
        // Update widget content
        console.log(`🔄 Actualizando widget ${config.id}:`, data);
      },
      remove: () => {
        widget.remove();
      }
    };
  }

  exportData(format = 'json') {
    const data = {
      stats: this.getCurrentStats(),
      filters: this.filters,
      timestamp: new Date().toISOString()
    };
    
    if (format === 'json') {
      this.downloadJSON(data, 'dashboard_data');
    } else if (format === 'csv') {
      this.downloadCSV(data, 'dashboard_data');
    }
  }

  getCurrentStats() {
    const stats = {};
    this.statsCards.forEach(card => {
      const type = card.dataset.cardType;
      const value = card.querySelector('.stats-value')?.textContent;
      if (type && value) {
        stats[type] = value;
      }
    });
    return stats;
  }

  downloadJSON(data, filename) {
    const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    this.downloadBlob(blob, `${filename}.json`);
  }

  downloadCSV(data, filename) {
    // Convert data to CSV format
    const csv = this.convertToCSV(data);
    const blob = new Blob([csv], { type: 'text/csv' });
    this.downloadBlob(blob, `${filename}.csv`);
  }

  convertToCSV(data) {
    // Simple CSV conversion
    let csv = 'Metric,Value\n';
    Object.keys(data.stats).forEach(key => {
      csv += `${key},${data.stats[key]}\n`;
    });
    return csv;
  }

  downloadBlob(blob, filename) {
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  }

  destroy() {
    // Cleanup
    if (this.refreshInterval) {
      clearInterval(this.refreshInterval);
    }
    
    if (this.websocket) {
      this.websocket.close();
    }
    
    // Remove event listeners
    window.removeEventListener('resize', this.handleResize);
    window.removeEventListener('focus', this.handleWindowFocus);
    window.removeEventListener('blur', this.handleWindowBlur);
    document.removeEventListener('visibilitychange', this.handleVisibilityChange);
    
    console.log('🧹 Dashboard destruido');
  }
}

// Estilos adicionales para el dashboard
const additionalStyles = `
.dashboard-container {
  animation: dashboardFadeIn 0.6s ease-out;
}

@keyframes dashboardFadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.stats-card {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
}

.stats-card.expanded {
  transform: translateY(-4px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
}

.card-details {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid var(--border-color);
}

.detail-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 0;
  font-size: 13px;
}

.detail-label {
  color: var(--text-secondary);
  font-weight: 500;
}

.detail-value {
  color: var(--text-primary);
  font-weight: 600;
}

.detail-progress {
  display: flex;
  align-items: center;
  gap: 8px;
}

.progress-bar {
  width: 60px;
  height: 4px;
  background: var(--border-color);
  border-radius: 2px;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  background: var(--primary-green);
  transition: width 0.5s ease;
}

.loading-spinner {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  color: var(--text-secondary);
}

.quick-action-btn.loading {
  opacity: 0.6;
  pointer-events: none;
}

.quick-action-btn.loading::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 16px;
  height: 16px;
  border: 2px solid transparent;
  border-top: 2px solid currentColor;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

.action-toast {
  position: fixed;
  top: 100px;
  right: 20px;
  background: var(--card-bg);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius-large);
  padding: 16px 20px;
  display: flex;
  align-items: center;
  gap: 12px;
  z-index: 10000;
  transform: translateX(400px);
  opacity: 0;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.action-toast.show {
  transform: translateX(0);
  opacity: 1;
}

.action-toast.success {
  border-color: rgba(0, 255, 102, 0.3);
}

.toast-icon {
  font-size: 18px;
}

.toast-message {
  font-size: 14px;
  color: var(--text-primary);
}

.notification-toast {
  position: fixed;
  top: 100px;
  right: 20px;
  background: var(--card-bg);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius-large);
  padding: 16px;
  max-width: 300px;
  z-index: 10000;
  transform: translateX(400px);
  opacity: 0;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.notification-toast.show {
  transform: translateX(0);
  opacity: 1;
}

.toast-title {
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 4px;
}

.refresh-btn.refreshing {
  animation: spin 1s linear infinite;
  opacity: 0.6;
}

.refresh-indicator {
  position: fixed;
  top: 80px;
  left: 50%;
  transform: translateX(-50%);
  background: var(--card-bg);
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  padding: 8px 16px;
  font-size: 13px;
  color: var(--text-primary);
  z-index: 9999;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}

.refresh-indicator.show {
  opacity: 1;
  visibility: visible;
}

.filtering-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(2px);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 10;
}

.filtering-overlay.show {
  opacity: 1;
  visibility: visible;
}

.filter-btn {
  transition: all 0.2s ease;
}

.filter-btn.active {
  background: var(--primary-green);
  color: var(--black);
}

.status-indicator {
  cursor: pointer;
  transition: all 0.2s ease;
}

.status-indicator:hover {
  transform: scale(1.1);
}

.status-indicator.active {
  transform: scale(1.15);
  filter: brightness(1.2);
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

@media (max-width: 768px) {
  .action-toast,
  .notification-toast {
    right: 10px;
    left: 10px;
    max-width: none;
    transform: translateY(100px);
  }
  
  .action-toast.show,
  .notification-toast.show {
    transform: translateY(0);
  }
}
`;

// Inyectar estilos adicionales
const styleSheet = document.createElement("style");
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);

// Inicializar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  new DashboardManager();
});

// Exportar para uso global
window.DashboardManager = DashboardManager;