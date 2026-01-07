<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acceso Denegado | Tech Home</title>
    <link rel="icon" type="image/png" href="{{ asset('images/faviconTH.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/errors/403.css') }}">
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
                <h1 class="error-code" data-text="403">403</h1>
            </div>
            
            <h2 class="error-title">ACCESO DENEGADO</h2>
            <div class="error-divider"></div>
            
            <p class="error-message">
                Protocolo de seguridad activado.<br>
                No tienes credenciales suficientes para acceder a este sector.
            </p>
            
            <div class="error-actions">
                <a href="{{ url('/') }}" class="btn-neon">
                    <span class="btn-text">VOLVER AL CENTRO DE MANDO</span>
                    <span class="btn-glitch"></span>
                </a>
            </div>

            <div class="system-log">
                <span id="logOutput">> Warning: Unauthorized access attempt_</span>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/errors/403.js') }}"></script>
</body>
</html>
