<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento - PromptVault</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendario/edit.css') }}">
</head>

<body>
    @include('layouts.loading')
    
    <div class="dashboard-layout">
        @include('layouts.sidebar')
        
        <div class="main-content">
            @include('layouts.header', ['header_title' => 'Editar Evento'])
            
            <div class="dashboard-content">

<div class="edit-evento-container">
    <div class="form-header">
        <h2>Editar Evento</h2>
        <div class="actions">
            <a href="{{ route('calendario.show', $id) }}" class="btn btn-info">
                Ver Detalles
            </a>
            <a href="{{ route('calendario.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </div>
    </div>
    
    <form id="editEventoForm" class="form-section">
        <!-- Campos del formulario aquí -->
    </form>
</div>

            </div>
        </div>
    </div>

    <script src="{{ asset('JavaScript/layouts/loading.js') }}"></script>
    <script src="{{ asset('JavaScript/components/sidebar.js') }}"></script>
    <script src="{{ asset('JavaScript/calendario/edit.js') }}"></script>

</body>
</html>