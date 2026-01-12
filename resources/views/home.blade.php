<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PromptVault - Biblioteca de Prompts</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            color: #fff;
        }
        
        /* Header */
        .header {
            background: rgba(15, 15, 35, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(225, 29, 72, 0.3);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #e11d48;
        }
        
        .nav-links {
            display: flex;
            gap: 1rem;
        }
        
        .nav-links a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .nav-links a:hover {
            background: rgba(225, 29, 72, 0.2);
        }
        
        .btn-primary {
            background: #e11d48;
            color: #fff;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: #be123c;
            transform: translateY(-2px);
        }
        
        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        /* Hero Section */
        .hero {
            text-align: center;
            padding: 3rem 0;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fff 0%, #e11d48 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .hero p {
            font-size: 1.2rem;
            color: #9ca3af;
            max-width: 600px;
            margin: 0 auto 2rem;
        }
        
        /* Search Bar */
        .search-container {
            max-width: 600px;
            margin: 0 auto 3rem;
        }
        
        .search-form {
            display: flex;
            gap: 0.5rem;
        }
        
        .search-input {
            flex: 1;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-size: 1rem;
        }
        
        .search-input::placeholder {
            color: #6b7280;
        }
        
        .search-btn {
            padding: 1rem 2rem;
            border-radius: 12px;
            background: #e11d48;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }
        
        /* Tags */
        .tags-section {
            margin-bottom: 2rem;
        }
        
        .tags-section h3 {
            margin-bottom: 1rem;
            color: #9ca3af;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .tags-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .tag {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            text-decoration: none;
            color: #fff;
            transition: all 0.3s;
        }
        
        .tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        /* Prompts Grid */
        .prompts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }
        
        .prompt-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s;
        }
        
        .prompt-card:hover {
            transform: translateY(-4px);
            border-color: rgba(225, 29, 72, 0.5);
            box-shadow: 0 8px 30px rgba(225, 29, 72, 0.15);
        }
        
        .prompt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .prompt-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
        }
        
        .prompt-title:hover {
            color: #e11d48;
        }
        
        .prompt-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: #f59e0b;
            font-size: 0.9rem;
        }
        
        .prompt-description {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .prompt-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: #6b7280;
        }
        
        .prompt-author {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .author-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #e11d48;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
        }
        
        .prompt-stats {
            display: flex;
            gap: 1rem;
        }
        
        .prompt-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .prompt-tag {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }
        
        .pagination a, .pagination span {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            text-decoration: none;
        }
        
        .pagination .active {
            background: #e11d48;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <i class="fas fa-bolt"></i> PromptVault
        </div>
        <nav class="nav-links">
            @auth
                <a href="{{ route('prompts.index') }}">Mis Prompts</a>
                <a href="{{ route('perfil.index') }}">Perfil</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-primary">Cerrar Sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-primary">Iniciar Sesión</a>
            @endauth
        </nav>
    </header>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero -->
        <section class="hero">
            <h1>Biblioteca de Prompts</h1>
            <p>Descubre y comparte los mejores prompts para IA. Explora nuestra colección pública de prompts optimizados.</p>
        </section>
        
        <!-- Search -->
        <div class="search-container">
            <form action="{{ route('home') }}" method="GET" class="search-form">
                <input type="text" name="buscar" class="search-input" placeholder="Buscar prompts..." value="{{ request('buscar') }}">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>
        
        <!-- Tags -->
        @if($etiquetas->count())
        <section class="tags-section">
            <h3>Etiquetas Populares</h3>
            <div class="tags-list">
                @foreach($etiquetas->take(12) as $etiqueta)
                    <a href="{{ route('home', ['etiqueta' => $etiqueta->nombre]) }}" 
                       class="tag" 
                       style="background: {{ $etiqueta->color_hex ?? '#6b7280' }};">
                        {{ $etiqueta->nombre }}
                    </a>
                @endforeach
            </div>
        </section>
        @endif
        
        <!-- Prompts Grid -->
        @if($prompts->count())
            <div class="prompts-grid">
                @foreach($prompts as $prompt)
                    <article class="prompt-card">
                        <div class="prompt-header">
                            <a href="{{ route('login') }}" class="prompt-title">{{ $prompt->titulo }}</a>
                            @if($prompt->promedio_calificacion > 0)
                                <div class="prompt-rating">
                                    <i class="fas fa-star"></i>
                                    {{ number_format($prompt->promedio_calificacion, 1) }}
                                </div>
                            @endif
                        </div>
                        
                        <p class="prompt-description">
                            {{ $prompt->descripcion ?? Str::limit($prompt->contenido, 150) }}
                        </p>
                        
                        <div class="prompt-meta">
                            <div class="prompt-author">
                                <div class="author-avatar">
                                    {{ substr($prompt->user->name, 0, 1) }}
                                </div>
                                {{ $prompt->user->name }}
                            </div>
                            <div class="prompt-stats">
                                <span><i class="fas fa-eye"></i> {{ $prompt->conteo_vistas }}</span>
                                <span><i class="fas fa-code-branch"></i> v{{ $prompt->version_actual }}</span>
                            </div>
                        </div>
                        
                        @if($prompt->etiquetas->count())
                            <div class="prompt-tags">
                                @foreach($prompt->etiquetas->take(3) as $etiqueta)
                                    <span class="prompt-tag" style="background: {{ $etiqueta->color_hex ?? '#6b7280' }}20; color: {{ $etiqueta->color_hex ?? '#fff' }};">
                                        {{ $etiqueta->nombre }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                {{ $prompts->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-file-alt"></i>
                <h3>No hay prompts públicos aún</h3>
                <p>Sé el primero en compartir un prompt con la comunidad.</p>
                @guest
                    <a href="{{ route('login') }}" class="btn-primary" style="margin-top: 1rem; display: inline-block;">
                        Iniciar Sesión para Crear
                    </a>
                @endguest
            </div>
        @endif
    </main>
</body>
</html>
