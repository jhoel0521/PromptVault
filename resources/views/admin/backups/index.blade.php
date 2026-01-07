@extends('layouts.admin')

@section('title', 'Gestión de Backups')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/backups/index.css') }}">
@endsection

@section('content')
<div class="backups-container">
    <div class="page-header">
        <h2>Gestión de Backups</h2>
        <div class="actions">
            <button id="createBackup" class="btn btn-primary">
                Crear Backup
            </button>
        </div>
    </div>
    
    <!-- Estadísticas -->
    <div class="stats-section">
        <div class="stat-card">
            <h3>Total de Backups</h3>
            <div class="stat-number">{{ $totalBackups ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h3>Último Backup</h3>
            <div class="stat-text">{{ $ultimoBackup ?? 'Nunca' }}</div>
        </div>
        <div class="stat-card">
            <h3>Tamaño Total</h3>
            <div class="stat-text">{{ $tamañoTotal ?? '0 MB' }}</div>
        </div>
    </div>
    
    <!-- Lista de backups -->
    <div class="table-section">
        <!-- Tabla aquí -->
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/admin/backups/index.js') }}"></script>
@endsection