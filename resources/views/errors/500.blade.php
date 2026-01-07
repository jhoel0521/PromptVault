<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Error Interno | Tech Home</title>
    <link rel="icon" type="image/png" href="{{ asset('images/faviconTH.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/errors/500.css') }}">
</head>
<body>
    <div class="error-container">
        <!-- Tech Background Elements -->
        <div class="tech-bg-grid"></div>
        <div class="tech-particles">
            <div class="tp tp-1"></div>
            <div class="tp tp-2"></div>
            <div class="tp tp-3"></div>
        </div>

        <div class="error-content">
            <div class="glitch-wrapper">
                <h1 class="error-code" data-text="500">500</h1>
            </div>
            
            <h2 class="error-title">FALLA CRÍTICA DEL SISTEMA</h2>
            <div class="error-divider"></div>
            
            <p class="error-message">
                Error interno del servidor detectado.<br>
                Nuestros ingenieros han sido notificados. Intente reiniciar la conexión.
            </p>
            
            <div class="error-actions">
                <button onclick="location.reload()" class="btn-neon btn-retry">
                    <span class="btn-text">REINICIAR CONEXIÓN</span>
                    <span class="btn-glitch"></span>
                </button>
                <a href="{{ url('/') }}" class="btn-neon">
                    <span class="btn-text">TERMINAR SESIÓN</span>
                    <span class="btn-glitch"></span>
                </a>
            </div>

            <div class="system-log">
                <span id="logOutput">> Critical Error: Kernel panic detected_</span>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/errors/500.js') }}"></script>
</body>
</html>
