<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Evento - PromptVault</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/calendario/create.css') }}">
</head>

<body>
    
    
    <div class="dashboard-layout">
        @include('layouts.sidebar')
        
        <div class="main-content">
            @include('layouts.header', ['header_title' => 'Crear Evento'])
            
            <div class="dashboard-content">

<div class="create-evento-container">
    <div class="form-header">
        <h2>Crear Nuevo Evento</h2>
        <a href="{{ route('calendario.index') }}" class="btn btn-secondary">
            Volver
        </a>
    </div>
    
    <form id="createEventoForm" class="form-section">
        <!-- Campos del formulario aquí -->
    </form>
</div>

            </div>
        </div>
    </div>

    
    <script src="{{ asset('JavaScript/components/sidebar.js') }}"></script>
    <script src="{{ asset('JavaScript/calendario/create.js') }}"></script>

</body>
</html>