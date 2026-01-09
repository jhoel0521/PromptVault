<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario - PromptVault</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">
    
    <!-- Precargar fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS del Dashboard -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendario/index.css') }}">
</head>

<body>
    
    <!-- Loading Screen -->
    @include('layouts.loading')
    
    <!-- Layout del Dashboard -->
    <div class="dashboard-layout">
        
        <!-- Sidebar Component -->
        @include('layouts.sidebar')
        
        <!-- Main Content -->
        <div class="main-content">
            
            <!-- Header Component -->
            @include('layouts.header', ['header_title' => 'Calendario'])
            
            <!-- Contenido principal -->
            <div class="dashboard-content">

<div class="calendario-container">
    <div class="control-panel">
        <div class="panel-header">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="title-content">
                    <h2>Calendario Académico</h2>
                    <span class="subtitle">Gestión de eventos y fechas importantes</span>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn-secondary-action">
                    <i class="fas fa-file-export"></i>
                    <span>Exportar</span>
                </button>
                <button class="btn-secondary-action">
                    <i class="fas fa-list"></i>
                    <span>Lista</span>
                </button>
                <button class="btn-primary-action" id="btnNewEvent">
                    <i class="fas fa-plus"></i>
                    <span>Nuevo Evento</span>
                </button>
            </div>
        </div>

        <div class="calendar-controls">
            <!-- Left: Filter Group (Dropdowns moved here or stays right? User said "mas opciones a lado de diciembre" helps intuitive... 
                 Actually, looking at the previous user image, the arrows were on left, title center, dropdowns right.
                 Current request: "las flechas de cambiar de mes deben estar en los costados de diciembre 2025".
                 So structure: [Optional: "Hoy" button] [ < ] [ Title ] [ > ] [ Dropdowns ]
                 Let's center the Title+Arrows combo.
            -->
            
            <div class="left-controls">
                <div class="view-toggles">
                    <button class="view-btn active">Mes</button>
                    <button class="view-btn">Semana</button>
                    <button class="view-btn">Agenda</button>
                </div>
            </div>

            <div class="center-nav">
                <button class="btn-nav large-nav" id="prevMonth"><i class="fas fa-chevron-left"></i></button>
                <h3 class="current-month" id="currentMonthDisplay">Diciembre 2025</h3>
                <button class="btn-nav large-nav" id="nextMonth"><i class="fas fa-chevron-right"></i></button>
            </div>
            
            <div class="filter-group-cal">
                <select class="cal-select" id="monthSelect">
                    <!-- Options... -->
                    <option value="0">Enero</option>
                    <option value="1">Febrero</option>
                    <option value="2">Marzo</option>
                    <option value="3">Abril</option>
                    <option value="4">Mayo</option>
                    <option value="5">Junio</option>
                    <option value="6">Julio</option>
                    <option value="7">Agosto</option>
                    <option value="8">Septiembre</option>
                    <option value="9">Octubre</option>
                    <option value="10">Noviembre</option>
                    <option value="11" selected>Diciembre</option>
                </select>
                <select class="cal-select" id="yearSelect">
                    <option value="2024">2024</option>
                    <option value="2025" selected>2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>
        </div>
    </div>

    <div class="calendar-layout">
        <div class="calendar-grid">
            <div class="weekdays">
                <div>Dom</div>
                <div>Lun</div>
                <div>Mar</div>
                <div>Mié</div>
                <div>Jue</div>
                <div>Vie</div>
                <div>Sáb</div>
            </div>
            <div class="days" id="calendarDays">
                <!-- Days will be generated by JS -->
            </div>
        </div>

        <div class="upcoming-events">
            <h3>Próximos Eventos</h3>
            <div class="event-list" id="upcomingEventsList">
                <div class="event-item">
                    <div class="event-date">
                        <span class="day">15</span>
                        <span class="month">DIC</span>
                    </div>
                    <div class="event-info">
                        <h4>Entrega de Notas</h4>
                        <span class="event-badge academic">Académico</span>
                    </div>
                </div>
                
                <div class="event-item">
                    <div class="event-date">
                        <span class="day">18</span>
                        <span class="month">DIC</span>
                    </div>
                    <div class="event-info">
                        <h4>Reunión de Profesores</h4>
                        <span class="event-badge meeting">Reunión</span>
                    </div>
                </div>

                <div class="event-item">
                    <div class="event-date">
                        <span class="day">20</span>
                        <span class="month">DIC</span>
                    </div>
                    <div class="event-info">
                        <h4>Fin de Semestre</h4>
                        <span class="event-badge holiday">Feriado</span>
                    </div>
                </div>

                <div class="event-item">
                    <div class="event-date">
                        <span class="day">22</span>
                        <span class="month">DIC</span>
                    </div>
                    <div class="event-info">
                        <h4>Examen Final Matemáticas</h4>
                        <span class="event-badge exam">Examen</span>
                    </div>
                </div>

                <div class="event-item">
                    <div class="event-date">
                        <span class="day">24</span>
                        <span class="month">DIC</span>
                    </div>
                    <div class="event-info">
                        <h4>Fiesta de Navidad</h4>
                        <span class="event-badge holiday">Social</span>
                    </div>
                </div>

                <div class="event-item">
                    <div class="event-date">
                        <span class="day">26</span>
                        <span class="month">DIC</span>
                    </div>
                    <div class="event-info">
                        <h4>Recuperatorio Física</h4>
                        <span class="event-badge exam">Examen</span>
                    </div>
                </div>

                <div class="event-item">
                    <div class="event-date">
                        <span class="day">30</span>
                        <span class="month">DIC</span>
                    </div>
                    <div class="event-info">
                        <h4>Cierre Administrativo</h4>
                        <span class="event-badge meeting">Admin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Evento (Hidden by default) -->
<!-- Can be implemented later or now depending on scope. For index visual, not strictly required but good to have skeleton -->

            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('JavaScript/layouts/loading.js') }}"></script>
    <script src="{{ asset('JavaScript/components/sidebar.js') }}"></script>
    <script src="{{ asset('JavaScript/calendario/index.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>