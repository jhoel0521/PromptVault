<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Sistema - PromptVault</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Precargar fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS del login -->
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">

    <!-- Meta tags para SEO -->
    <meta name="description" content="Accede a tu cuenta en PromptVault. Sistema de gestión centralizada de prompts de IA con versionado, organización y colaboración.">
    <meta name="keywords" content="login, prompts, IA, inteligencia artificial, gestión, versionado">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph -->
    <meta property="og:title" content="Iniciar Sesión - PromptVault">
    <meta property="og:description" content="Accede a tu cuenta en PromptVault">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
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
    <div class="main-login-wrapper">
        <div class="floating-container">

            <!-- Panel Izquierdo - Branding Profesional -->
            <div class="login-branding">
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
                            <img src="{{ asset('images/LogoLoginPrompt.png') }}" alt="PromptVault Logo" class="brand-logo" style="max-width: 120px; height: auto;">
                        </div>
                        <h1 style="color: #fff; font-size: 3.5rem; font-weight: 900; margin: 20px 0 0 0; font-family: 'Montserrat', sans-serif; letter-spacing: 3px; text-transform: uppercase;">PROMPTVAULT</h1>
                        <div class="brand-text">
                            <div class="brand-line"></div>
                        </div>
                    </div>

                    <!-- Mensaje profesional -->
                    <div class="welcome-section">
                        <h2 class="welcome-title">¡Bienvenido a PROMPTVAULT!</h2>
                        <p class="welcome-description">
                            Tu plataforma centralizada para gestionar prompts de IA. Organiza, versiona y colabora con tu equipo. Maximiza la efectividad de tus interacciones con sistemas de inteligencia artificial.
                        </p>
                    </div>

                    <!-- Sección de funcionalidades -->
                    <div class="social-section">
                        <p class="social-text">¿Qué puedes hacer en la plataforma?</p>
                        <p class="social-title">¡Explora nuestras funcionalidades!</p>
                        <div class="social-media-links">
                            <a href="#" class="social-link tiktok" title="Biblioteca de Prompts">
                                <div class="social-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                    </svg>
                                </div>
                                <span>Biblioteca</span>
                            </a>
                            <a href="#" class="social-link facebook" title="Versionado">
                                <div class="social-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        <path d="M12 6v6l5 3"/>
                                    </svg>
                                </div>
                                <span>Versionado</span>
                            </a>
                            <a href="#" class="social-link instagram" title="Colaboración">
                                <div class="social-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                    </svg>
                                </div>
                                <span>Colaboración</span>
                            </a>
                            <a href="#" class="social-link whatsapp" title="IA Integrada">
                                <div class="social-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                        <path d="M12 8v8M8 12h8"/>
                                    </svg>
                                </div>
                                <span>IA Integrada</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección derecha - Formulario de login -->
            <div class="login-form-section">
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

                <div class="form-container"> <!-- Header del formulario -->
                    <div class="form-header">
                        <h2 class="form-title">Iniciar Sesión</h2>
                        <p class="form-subtitle">Ingresa tus credenciales para continuar</p>
                    </div>

                    <!-- Mensajes de error/éxito -->
                    @if($errors->any())
                    <div class="alert alert-error">
                        <div class="alert-icon">⚠️</div>
                        <div class="alert-message">{{ $errors->first() }}</div>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success">
                        <div class="alert-icon">✅</div>
                        <div class="alert-message">{{ session('success') }}</div>
                    </div>
                    @endif

                    <!-- Formulario de login -->
                    <form class="login-form" method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        <!-- Campo Email -->
                        <div class="input-group">
                            <label for="email" class="input-label">Correo Electrónico</label>
                            <div class="input-wrapper">
                                <div class="input-icon">✉</div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-input"
                                    placeholder="Escribe tu email aquí..."
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email">
                            </div>
                            <div class="input-error" id="emailError"></div>
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="input-group">
                            <label for="password" class="input-label">Contraseña</label>
                            <div class="input-wrapper">
                                <div class="input-icon">🔒</div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-input"
                                    placeholder="Escribe tu contraseña aquí..."
                                    required
                                    autocomplete="current-password">
                            </div>
                            <div class="input-error" id="passwordError"></div>
                        </div>

                        <!-- Recordar y Olvidé contraseña -->
                        <div class="form-options">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remember" id="remember" class="checkbox-input">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">Recordarme</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="forgot-password" id="forgotPasswordLink">¿Olvidaste tu contraseña?</a>
                        </div>

                        <!-- Botón de submit -->
                        <button type="submit" class="login-button btn-nexorium" id="loginButton">
                            <span class="button-text">ACCESO SISTEMA</span>
                            <span class="button-loader" id="buttonLoader">
                                <div class="loader-spinner"></div>
                            </span>
                        </button>

                    </form>

                    <!-- Footer del formulario -->
                    <div class="form-footer">
                        <p class="register-text">
                            ¿No tienes una cuenta?
                            <span class="highlight"><a href="{{ route('register') }}" class="register-link" id="registerLink">¡Regístrate aquí!</a></span>
                        </p>

                        <!-- Social Media Links -->
                        <div class="social-media-links">
                            <a href="#" class="social-link mototaxi" title="Servicios de Mototaxi">
                                <div class="social-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                        <path d="M12 2c-4.42 0-8 3.58-8 8 0 5.25 7.24 11.4 7.52 11.65.14.13.32.2.48.2s.34-.07.48-.2C12.76 21.4 20 15.25 20 10c0-4.42-3.58-8-8-8zm0 11.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"/>
                                        <circle cx="12" cy="10" r="2"/>
                                        <path d="M6 18h12l-1 3H7l-1-3z"/>
                                    </svg>
                                </div>
                                <span>Servicios</span>
                            </a>
                            <a href="#" class="social-link conductores" title="Conductores">
                                <div class="social-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        <path d="M15.5 8.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5S14 6.17 14 7s.67 1.5 1.5 1.5z"/>
                                        <path d="M8.5 8.5c.83 0 1.5-.67 1.5-1.5S9.33 5.5 8.5 5.5 7 6.17 7 7s.67 1.5 1.5 1.5z"/>
                                    </svg>
                                </div>
                                <span>Conductores</span>
                            </a>
                            <a href="#" class="social-link tarifas" title="Tarifas">
                                <div class="social-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                                    </svg>
                                </div>
                                <span>Tarifas</span>
                            </a>
                            <a href="#" class="social-link support" title="Soporte">
                                <div class="social-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                        <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM9 11H7V9h2v2zm4 0h-2V9h2v2zm4 0h-2V9h2v2z"/>
                                        <circle cx="12" cy="15" r="1.5"/>
                                    </svg>
                                </div>
                                <span>Soporte 24/7</span>
                            </a>
                        </div>

                        <!-- Register Link -->
                        <div class="register-section">
                            <p class="no-account-text">¿No tienes una cuenta?
                                <span class="highlight"><a href="{{ route('register') }}" class="register-link-main" id="registerMainLink">¡Regístrate aquí!</a></span>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/auth/login.js') }}"></script>

    <!-- Analytics (opcional) -->
    <script>
        // Google Analytics o similar
        console.log('🔐 PROMPTVAULT Login: Página cargada correctamente');
    </script>

</body>

</html>