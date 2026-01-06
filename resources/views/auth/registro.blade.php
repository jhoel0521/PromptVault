<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Tech Home</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Únete a la Asociación 1ro de Junio. Registro seguro para conductores de mototaxi y miembros de nuestra comunidad.">
    <meta name="keywords" content="registro, asociación, mototaxi, 1ro de junio, conductores, transporte">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph -->
    <meta property="og:title" content="Registro - Asociación 1ro de Junio">
    <meta property="og:description" content="Únete a nuestra asociación de conductores de mototaxi">
    <meta property="og:type" content="website">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/faviconTH.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/auth/registro.css') }}?v={{ time() }}">
</head>

<body>
    <!-- Background animado -->
    <div class="login-background">
        <div class="bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>
        <div class="bg-grid"></div>
        <!-- Elementos robóticos -->
        <div class="tech-elements">
            <div class="robot-parts">
                <div class="gear gear-1"></div>
                <div class="gear gear-2"></div>
                <div class="gear gear-3"></div>
                <div class="gear gear-4"></div>
                <div class="circuit-board cb-1"></div>
                <div class="circuit-board cb-2"></div>
                <div class="circuit-board cb-3"></div>
                <div class="circuit-board cb-4"></div>
                <div class="led-indicator led-1"></div>
                <div class="led-indicator led-2"></div>
                <div class="led-indicator led-3"></div>
                <div class="led-indicator led-4"></div>
                <div class="led-indicator led-5"></div>
                <div class="led-indicator led-6"></div>
                <!-- Nuevos elementos robóticos -->
                <div class="robot-eye re-1"></div>
                <div class="robot-eye re-2"></div>
                <div class="robot-eye re-3"></div>
                <div class="data-stream ds-1"></div>
                <div class="data-stream ds-2"></div>
                <div class="data-stream ds-3"></div>
                <div class="tech-particle tp-1"></div>
                <div class="tech-particle tp-2"></div>
                <div class="tech-particle tp-3"></div>
                <div class="tech-particle tp-4"></div>
                <div class="tech-particle tp-5"></div>
            </div>
        </div>
    </div>

    <!-- Contenedor principal flotante -->
    <div class="main-register-wrapper">
        <div class="floating-container">

            <!-- Panel Izquierdo - Branding Profesional -->
            <div class="register-branding">
                <!-- Efectos de background -->
                <div class="branding-effects">
                    <div class="gradient-mesh"></div>
                    <div class="floating-elements">
                        <div class="float-element element-1"></div>
                        <div class="float-element element-2"></div>
                        <div class="float-element element-3"></div>
                    </div>
                </div>

                <div class="branding-content">
                    <!-- Logo y marca - Diseño profesional -->
                    <div class="brand-section">
                        <div class="logo-container">
                            <div class="logo-backdrop"></div>
                            <img src="{{ asset('images/LogoTech.png') }}" alt="Logo" class="brand-logo">
                        </div>
                        <div class="brand-line"></div>
                    </div>

                    <!-- Mensaje profesional -->
                    <div class="welcome-section">
                        <h2 class="welcome-title">¡Únete a TECH HOME!</h2>
                        <p class="welcome-description">
                            Forma parte de la comunidad educativa más innovadora en tecnología. Accede a cursos especializados, 
                            certificaciones y una plataforma completa de aprendizaje digital.
                        </p>
                    </div>

                    <!-- Cards informativas -->
                    <div class="info-cards">
                        <div class="info-card">
                            <div class="card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2L3 7L12 12L21 7L12 2Z" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3 17L12 22L21 17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3 12L12 17L21 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="card-content">
                                <h4>Encriptación Avanzada</h4>
                                <p>Protección de datos de nivel bancario</p>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" fill="none" stroke="currentColor" stroke-width="2"/>
                                    <polyline points="22,6 12,13 2,6" fill="none" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            </div>
                            <div class="card-content">
                                <h4>Verificación por Email</h4>
                                <p>Confirmación segura en tu correo</p>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <polygon points="13,2 3,14 12,14 11,22 21,10 12,10 13,2" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="card-content">
                                <h4>Proceso Rápido</h4>
                                <p>Recupera tu acceso en minutos</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de redes sociales -->
                    <div class="social-section">
                        <p class="social-text">¿Necesitas ayuda con la plataforma?</p>
                        <h3 class="social-title">¡Estamos aquí para ayudarte!</h3>
                        <div class="social-media-links">
                            <a href="#" class="social-link tiktok" target="_blank">
                                <div class="social-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.10z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <span>TikTok</span>
                            </a>
                            <a href="#" class="social-link facebook" target="_blank">
                                <div class="social-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <span>Facebook</span>
                            </a>
                            <a href="#" class="social-link instagram" target="_blank">
                                <div class="social-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <span>Instagram</span>
                            </a>
                            <a href="#" class="social-link whatsapp" target="_blank">
                                <div class="social-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.525 3.488" fill="currentColor"/>
                                    </svg>
                                </div>
                                <span>WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Derecho - Formulario de Registro -->
            <div class="register-form-section">
                <!-- Líneas decorativas -->
                <div class="form-lines">
                    <div class="line line-1"></div>
                    <div class="line line-2"></div>
                    <div class="line line-3"></div>
                </div>

                <!-- Partículas decorativas -->
                <div class="form-particles">
                    <div class="particle particle-1"></div>
                    <div class="particle particle-2"></div>
                    <div class="particle particle-3"></div>
                    <div class="particle particle-4"></div>
                </div>

                <div class="form-container">
                    <!-- Encabezado del formulario -->
                    @if(request('step') === 'verify')
                    <div class="form-header">
                        <h2 class="form-title">Verificar Email</h2>
                        <p class="form-subtitle">Ingresa el código de 6 dígitos que enviamos a tu email para completar el registro.</p>
                    </div>
                    @else
                    <div class="form-header">
                        <h2 class="form-title">Crear Cuenta</h2>
                        <p class="form-subtitle">Ingresa tus datos para unirte al instituto TECH HOME</p>
                    </div>
                    @endif

                    <!-- Mostrar errores -->
                    @if($errors->any())
                    <div class="alert alert-error">
                        <span class="alert-icon">⚠️</span>
                        <div class="alert-message">
                            @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Mostrar mensaje de éxito -->
                    @if(session('success'))
                    <div class="alert alert-success">
                        <span class="alert-icon">✅</span>
                        <div class="alert-message">
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Formulario de registro -->
                    @if(request('step') === 'verify')
                    <!-- Paso 2: Verificación de email -->
                    <form class="register-form" method="POST" action="{{ route('register.verify') }}" id="registerForm">
                        @csrf
                        <input type="hidden" name="step" value="verify">
                        <input type="hidden" name="email" value="{{ session('verification_email') }}">

                        <!-- Campo Código -->
                        <div class="input-group">
                            <label for="code" class="input-label">Código de Verificación</label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="code"
                                    name="code"
                                    class="form-input"
                                    placeholder="Ingresa el código de 6 dígitos"
                                    maxlength="6"
                                    required
                                    autocomplete="one-time-code">
                            </div>
                            <div class="input-error" id="codeError"></div>
                            <div class="input-help">
                                <p>Revisa tu bandeja de entrada y spam. El código expira en <strong>10 minutos</strong>.</p>
                            </div>
                        </div>

                        <!-- Botón de submit -->
                        <button type="submit" class="register-button btn-asociacion" id="registerButton">
                            <span class="button-text">VERIFICAR Y COMPLETAR REGISTRO</span>
                            <span class="button-loader" id="buttonLoader">
                                <div class="loader-spinner"></div>
                            </span>
                        </button>

                        <!-- Reenviar código -->
                        <div class="resend-code">
                            <p>¿No recibiste el código?</p>
                            <a href="#" class="resend-link" id="resendCode">Reenviar código</a>
                        </div>

                    </form>
                    @else
                    <!-- Paso 1: Registro inicial -->
                    <form class="register-form" method="POST" action="{{ route('register.submit') }}" id="registerForm">
                        @csrf
                        <input type="hidden" name="step" value="register">

                        <!-- Fila de nombre y apellido -->
                        <div class="form-row">
                            <div class="input-group half-width">
                                <label for="name" class="input-label">Nombre</label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        class="form-input"
                                        placeholder="Tu nombre completo"
                                        value="{{ old('name') }}"
                                        required
                                        autocomplete="given-name">
                                </div>
                                <div class="input-error" id="nameError"></div>
                            </div>

                            <div class="input-group half-width">
                                <label for="apellido" class="input-label">Apellido</label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="apellido"
                                        name="apellido"
                                        class="form-input"
                                        placeholder="Tu apellido"
                                        value="{{ old('apellido') }}"
                                        required
                                        autocomplete="family-name">
                                </div>
                                <div class="input-error" id="apellidoError"></div>
                            </div>
                        </div>

                        <!-- Campo Email -->
                        <div class="input-group">
                            <label for="email" class="input-label">Correo Electrónico</label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-input"
                                    placeholder="tu-email@ejemplo.com"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email">
                            </div>
                            <div class="input-error" id="emailError"></div>
                        </div>

                        <!-- Fila de teléfono y país -->
                        <div class="form-row">
                            <div class="input-group half-width">
                                <label for="telefono" class="input-label">Teléfono (Opcional)</label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="tel"
                                        id="telefono"
                                        name="telefono"
                                        class="form-input"
                                        placeholder="+57 300 123 4567"
                                        value="{{ old('telefono') }}"
                                        autocomplete="tel">
                                </div>
                                <div class="input-error" id="telefonoError"></div>
                            </div>

                            <div class="input-group half-width">
                                <label for="ci" class="input-label">Cédula de Identidad</label>
                                <div class="input-wrapper">
                                    <div class="input-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                            <rect x="3" y="4" width="18" height="16" rx="2" fill="none" stroke="currentColor" stroke-width="2"/>
                                            <line x1="7" y1="8" x2="17" y2="8" stroke="currentColor" stroke-width="2"/>
                                            <line x1="7" y1="12" x2="13" y2="12" stroke="currentColor" stroke-width="2"/>
                                            <line x1="7" y1="16" x2="11" y2="16" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="ci"
                                        name="ci"
                                        class="form-input"
                                        placeholder="Ej: 12345678"
                                        value="{{ old('ci') }}"
                                        required
                                        autocomplete="off">
                                </div>
                                <div class="input-error" id="ciError"></div>
                            </div>
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="input-group">
                            <label for="password" class="input-label">Contraseña</label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-input"
                                    placeholder="Crea una contraseña segura"
                                    required
                                    autocomplete="new-password">
                            </div>
                            <div class="input-error" id="passwordError"></div>
                            <div class="input-help">
                                <p>Debe tener al menos <strong>8 caracteres</strong>, incluir mayúsculas, minúsculas y números.</p>
                            </div>
                        </div>

                        <!-- Campo Confirmar Contraseña -->
                        <div class="input-group">
                            <label for="confirm_password" class="input-label">Confirmar Contraseña</label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="confirm_password"
                                    name="password_confirmation"
                                    class="form-input"
                                    placeholder="Repite tu contraseña"
                                    required
                                    autocomplete="new-password">
                            </div>
                            <div class="input-error" id="confirmPasswordError"></div>
                        </div>

                        <!-- Checkboxes de términos -->
                        <div class="checkbox-group">
                            <label class="checkbox-label required">
                                <input type="checkbox" name="acepta_terminos" id="acepta_terminos" class="checkbox-input" required {{ old('acepta_terminos') ? 'checked' : '' }}>
                                <span class="checkbox-text">
                                    Acepto los <a href="#" class="link-terms">Términos y Condiciones</a>
                                    y la <a href="#" class="link-privacy">Política de Privacidad</a> de TECH HOME.
                                </span>
                            </label>

                            <label class="checkbox-label">
                                <input type="checkbox" name="acepta_marketing" id="acepta_marketing" class="checkbox-input" {{ old('acepta_marketing') ? 'checked' : '' }}>
                                <span class="checkbox-text">
                                    Deseo recibir información sobre nuevos cursos, certificaciones y novedades de la plataforma.
                                </span>
                            </label>
                        </div>

                        <!-- Botón de submit -->
                        <button type="submit" class="register-button btn-asociacion" id="registerButton">
                            <span class="button-text">CREAR MI CUENTA</span>
                            <span class="button-loader" id="buttonLoader">
                                <div class="loader-spinner"></div>
                            </span>
                        </button>

                    </form>
                    @endif

                    <!-- Footer del formulario -->
                    <div class="form-footer">
                        @if(request('step') === 'verify')
                        <div class="help-links">
                            <a href="#" class="help-link" id="contactSupport">
                                <span class="help-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z" fill="currentColor"/>
                                    </svg>
                                </span>
                                Soporte 24/7
                            </a>
                            <a href="#" class="help-link" id="helpCenter">
                                <span class="help-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-6h2v6zm0-8h-2V7h2v4z" fill="currentColor"/>
                                    </svg>
                                </span>
                                Centro de Ayuda
                            </a>
                        </div>
                        <div class="back-to-login">
                            <p>¿Ya tienes cuenta en TECH HOME?</p>
                            <a href="{{ route('login') }}" class="login-link">
                                ¡Inicia sesión aquí!
                            </a>
                        </div>
                        @else
                        <div class="back-to-login">
                            <p>¿Ya tienes cuenta en TECH HOME?</p>
                            <a href="{{ route('login') }}" class="login-link">
                                ¡Inicia sesión aquí!
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/auth/registro.js') }}"></script>
</body>

</html>