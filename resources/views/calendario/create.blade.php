@extends('layouts.admin')

@section('title', 'Crear Evento')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/calendario/create.css') }}">
@endsection

@section('content')
<div class="create-evento-container">
    <div class="form-header">
        <h2>Crear Nuevo Evento</h2>
        <a href="{{ route('admin.calendario.index') }}" class="btn btn-secondary">
            Volver
        </a>
    </div>
    
    <form id="createEventoForm" class="form-section">
        <!-- Campos del formulario aquí -->
    </form>
</div>
@endsection

@section('js')
<script src="{{ asset('js/admin/calendario/create.js') }}"></script>
@endsection