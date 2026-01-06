{{-- Header del Sistema - 1ro de Junio --}}
<header class="dashboard-header">
    <!-- Left: Brand & Search -->
    <div class="header-left">
        <div class="header-brand">
            <h1 class="brand-text">
                <a href="{{ route('admin.dashboard') }}" style="text-decoration: none; color: inherit;">
                    {{ $header_title ?? '1RO DE JUNIO' }}
                </a>
            </h1>
        </div>
        <div class="header-search">
            <form action="#" method="GET" class="search-form">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" id="globalSearch" placeholder="Buscar..." class="search-input" autocomplete="off">
            </form>
        </div>
    </div>

    <!-- Right: Actions & Profile -->
    <div class="header-right">
        
        <!-- Quick Actions (New) -->
        <div class="action-wrapper">
            <button class="action-btn" id="quickActionsToggle" aria-label="Acciones Rápidas" title="Acciones Rápidas">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
            </button>
            <!-- Quick Actions Dropdown -->
            <div class="quick-actions-dropdown" id="quickActionsDropdown">
                <div class="qa-header">Crear Nuevo</div>
                <div class="qa-grid">
                    <a href="#" class="qa-item">
                        <div class="qa-icon blue">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                        </div>
                        <span>Usuario</span>
                    </a>
                    <a href="#" class="qa-item">
                        <div class="qa-icon purple">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </div>
                        <span>Curso</span>
                    </a>
                    <a href="#" class="qa-item">
                        <div class="qa-icon green">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                        <span>Pago</span>
                    </a>
                    <a href="{{ route('reportes.index') }}" class="qa-item">
                        <div class="qa-icon orange">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="12" y1="18" x2="12" y2="12"></line>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                            </svg>
                        </div>
                        <span>Reporte</span>
                    </a>
                    <a href="#" class="qa-item">
                        <div class="qa-icon red">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <span>Mensaje</span>
                    </a>
                    <a href="#" class="qa-item">
                        <div class="qa-icon pink">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                            </svg>
                        </div>
                        <span>Tarea</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Help Button (New) -->
        <a href="#" class="action-btn" title="Ayuda y Soporte">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </a>



        <!-- Calendar Link (New) -->
        <a href="{{ route('admin.calendario.index') }}" class="action-btn" title="Calendario Académico">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </a>

        <!-- Notificaciones -->
        <div class="notification-wrapper">
            <button class="notification-btn" id="notificationToggle" aria-label="Notificaciones">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <span class="notification-badge pulse">3</span>
            </button>
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="dropdown-header">
                    <span>Notificaciones</span>
                    <a href="#" class="mark-read" onclick="event.preventDefault(); markAllAsRead();">Marcar leídas</a>
                </div>
                <!-- Notification Items -->
                <div class="notif-item unread">
                    <div class="notif-icon blue">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="white" stroke="none">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div class="notif-content">
                        <p class="notif-title">Nuevo usuario registrado</p>
                        <p class="notif-time">Hace 5 min</p>
                    </div>
                </div>
                <div class="notif-item unread">
                    <div class="notif-icon green">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="white" stroke="none">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <div class="notif-content">
                        <p class="notif-title">Pago confirmado</p>
                        <p class="notif-time">Hace 1 hora</p>
                    </div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon yellow">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="white" stroke="none">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                        </svg>
                    </div>
                    <div class="notif-content">
                        <p class="notif-title">Actualización del sistema disponible</p>
                        <p class="notif-time">Hace 3 horas</p>
                    </div>
                </div>
                <div class="notif-item">
                    <div class="notif-icon red">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="white" stroke="none">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                    </div>
                    <div class="notif-content">
                        <p class="notif-title">Error en el sistema de respaldos</p>
                        <p class="notif-time">Hace 5 horas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Perfil de Usuario -->
        <div class="user-profile-container">
            @php
                $loggedInUser = auth()->user() ?? (session('user_id') ? \App\Models\User::find(session('user_id')) : null);
                $initial = $loggedInUser ? substr($loggedInUser->name, 0, 1) : (session('user_name') ? substr(session('user_name'), 0, 1) : 'U');
                $userName = $loggedInUser ? $loggedInUser->name : (session('user_name') ?? 'Usuario');
                $userRole = $loggedInUser ? ($loggedInUser->rol ?? 'Admin') : 'ADMIN';
                $userEmail = $loggedInUser ? $loggedInUser->email : (session('user_email') ?? 'admin@sistema.com');
            @endphp

            <button class="profile-trigger" id="profileDropdownToggle" aria-expanded="false">
                <div class="user-avatar-small">
                    @if($loggedInUser && $loggedInUser->avatar && file_exists(public_path('images/avatars/'.$loggedInUser->avatar)))
                        <img src="{{ asset('images/avatars/'.$loggedInUser->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    @else
                        <span>{{ $initial }}</span>
                    @endif
                </div>
                <div class="user-meta-compact">
                    <span class="user-name">{{ $userName }}</span>
                    <span class="user-role-badge">{{ $userRole }}</span>
                </div>
                <svg class="dropdown-arrow-small" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>

            <!-- Compact Profile Dropdown -->
            <div class="profile-dropdown compact" id="profileDropdown">
                <div class="pd-header-compact">
                    <div class="user-avatar-med">
                        @if($loggedInUser && $loggedInUser->avatar && file_exists(public_path('images/avatars/'.$loggedInUser->avatar)))
                            <img src="{{ asset('images/avatars/'.$loggedInUser->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            <span>{{ $initial }}</span>
                        @endif
                    </div>
                    <div class="pd-user-info">
                        <strong>{{ $userName }}</strong>
                        <small>{{ $userEmail }}</small>
                    </div>
                </div>
                
                <div class="pd-grid-menu">
                    <!-- 1. Perfil -->
                    <a href="{{ route('perfil.index') }}" class="pd-grid-item" title="Ver Perfil">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Perfil</span>
                    </a>
                    
                    <!-- 2. Reportes -->
                    <a href="{{ route('reportes.index') }}" class="pd-grid-item" title="Reportes">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span>Reportes</span>
                    </a>

                    <!-- 3. Actividad -->
                    <a href="#" class="pd-grid-item" title="Actividad Reciente">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                        <span>Actividad</span>
                    </a>

                    <!-- 4. Mensajes -->
                    <a href="#" class="pd-grid-item" title="Mensajes">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span>Msjs</span>
                    </a>

                    <!-- 5. Soporte -->
                    <a href="#" class="pd-grid-item" title="Soporte Técnico">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                        <span>Soporte</span>
                    </a>

                    <!-- 6. Ajustes -->
                    <a href="{{ route('configuraciones.index') }}" class="pd-grid-item" title="Configuración">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                        <span>Ajustes</span>
                    </a>
                </div>

                <div class="pd-footer-actions">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header JS Loaded Here -->
<script src="{{ asset('js/components/header.js') }}"></script>