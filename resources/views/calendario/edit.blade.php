@extends('layouts.admin')

@section('title', 'Editar Evento')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/calendario/edit.css') }}">
@endsection

@section('content')
<div class="edit-evento-container">
    <div class="form-header">
        <h2>Editar Evento</h2>
        <div class="actions">
            <a href="{{ route('admin.calendario.show', $evento->id) }}" class="btn btn-info">
                Ver Detalles
            </a>
            <a href="{{ route('admin.calendario.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </div>
    </div>
    
    <form id="editEventoForm" class="form-section">
        <!-- Campos del formulario aquí -->
    </form>
</div>
@endsection

@section('js')
<script src="{{ asset('js/admin/calendario/edit.js') }}"></script>
@endsection