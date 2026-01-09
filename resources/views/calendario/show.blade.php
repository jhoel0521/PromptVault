@extends('layouts.admin')

@section('title', 'Detalles del Evento')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/calendario/show.css') }}">
@endsection

@section('content')
<div class="show-evento-container">
    <div class="details-header">
        <h2>Detalles del Evento</h2>
        <div class="actions">
            <a href="{{ route('admin.calendario.edit', $evento->id) }}" class="btn btn-warning">
                Editar
            </a>
            <a href="{{ route('admin.calendario.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </div>
    </div>
    
    <!-- Información del evento -->
    <div class="info-section">
        <!-- Detalles aquí -->
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/admin/calendario/show.js') }}"></script>
@endsection