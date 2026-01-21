<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? appName() }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/faviconTH.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- CSS específico de cada página -->
    @isset($css)
        <link rel="stylesheet" href="{{ asset($css) }}">
    @endisset
    
    <!-- Scripts Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{ $slot }}
    
    <!-- JS específico de cada página -->
    @isset($js)
        <script src="{{ asset($js) }}"></script>
    @endisset
</body>
</html>
