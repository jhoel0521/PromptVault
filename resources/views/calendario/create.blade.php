@php
    $user = Auth::user();
    $userRole = $user && $user->role ? $user->role->nombre : (session('user_role') ?? 'guest');
    $componentPath = match($userRole) {
        'admin' => 'components.administrador',
        'user' => 'components.usuario',
        'collaborator' => 'components.colaborador',
        default => 'components.invitado',
    };
@endphp

<x-dynamic-component :component="$componentPath">
    <x-slot name="header_title">Crear Evento</x-slot>

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