@extends('layouts.app')

@section('title', 'Buscador Global')

@section('css')
<link rel="stylesheet" href="{{ asset('css/buscador/index.css') }}">
@endsection

@section('content')
<div class="buscador-container">
    <div class="search-header">
        <h2>Búsqueda Global</h2>
        <p class="search-subtitle">Encuentra prompts, categorías, etiquetas, vistas del sistema y más</p>
    </div>
    
    <!-- Formulario de búsqueda con Live Search -->
    <div class="search-form-container">
        <form id="searchForm" class="search-form" method="GET" action="{{ route('buscador.index') }}">
            <div class="search-input-group">
                <input type="text" 
                       id="searchQuery" 
                       name="query" 
                       placeholder="Buscar vistas, prompts, categorías..." 
                       class="search-input"
                       value="{{ $query ?? '' }}"
                       autocomplete="off"
                       autofocus>
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
                
                <!-- Live Search Results -->
                <div id="liveSearchResults" class="live-search-results"></div>
            </div>
            
            <!-- Filtros de búsqueda -->
            <div class="search-filters">
                <div class="filter-group">
                    <label>Tipo de contenido:</label>
                    <div class="filter-options">
                        <label><input type="checkbox" name="tipos[]" value="prompts" checked> Prompts</label>
                        <label><input type="checkbox" name="tipos[]" value="categorias" checked> Categorías</label>
                        <label><input type="checkbox" name="tipos[]" value="etiquetas" checked> Etiquetas</label>
                        @if(auth()->user()->esAdmin())
                        <label><input type="checkbox" name="tipos[]" value="usuarios" checked> Usuarios</label>
                        @endif
                    </div>
                </div>
                
                <div class="filter-group">
                    <label for="orderBy">Ordenar por:</label>
                    <select name="orderBy" id="orderBy" class="form-control">
                        <option value="relevancia">Relevancia</option>
                        <option value="fecha">Fecha</option>
                        <option value="nombre">Nombre</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Resultados de búsqueda -->
    <div class="search-results-container">
        @if(isset($query) && $query)
        <div class="results-header">
            <h3>Resultados de búsqueda para: "{{ $query }}"</h3>
            <p class="results-count">{{ $total ?? 0 }} resultados encontrados</p>
        </div>
        
        <div class="results-content">
            @if(isset($resultados) && count($resultados) > 0)
                @foreach($resultados as $categoria => $items)
                <div class="result-category">
                    <h4>{{ ucfirst($categoria) }}</h4>
                    <div class="result-items">
                        @foreach($items as $item)
                        <div class="result-item">
                            <div class="result-icon">
                                <i class="fas fa-{{ $item['icono'] ?? 'file' }}"></i>
                            </div>
                            <div class="result-content">
                                <h5>{{ $item['titulo'] ?? 'Sin título' }}</h5>
                                <p>{{ $item['descripcion'] ?? 'Sin descripción' }}</p>
                                <small class="result-type">{{ $item['tipo'] ?? $categoria }}</small>
                            </div>
                            <div class="result-actions">
                                <a href="{{ $item['enlace'] ?? '#' }}" class="btn btn-sm btn-primary">
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
                <div class="no-results">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>No se encontraron resultados</h4>
                    <p>Intenta con otros términos de búsqueda o ajusta los filtros</p>
                </div>
            @endif
        </div>
        @endif
    </div>
    
    <!-- Búsquedas sugeridas -->
    <div class="suggested-searches">
        <h4>Búsquedas sugeridas</h4>
        <div class="suggestions-list">
            <button class="suggestion-btn" data-query="dashboard">Dashboard</button>
            <button class="suggestion-btn" data-query="prompts">Prompts</button>
            <button class="suggestion-btn" data-query="calendario">Calendario</button>
            <button class="suggestion-btn" data-query="configuraciones">Configuraciones</button>
            <button class="suggestion-btn" data-query="crear">Crear Nuevo</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('JavaScript/buscador/index.js') }}"></script>
@endsection