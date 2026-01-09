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
    <x-slot name="header_title">Detalle del Evento</x-slot>

<div class="show-evento-container">
    <div class="details-header">
        <h2>Detalles del Evento</h2>
        <div class="actions">
            <a href="{{ route('calendario.edit', $id) }}" class="btn btn-warning">
                Editar
            </a>
            <a href="{{ route('calendario.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </div>
    </div>
    
    <!-- Información del evento -->
    <div class="info-section">
        <!-- Detalles aquí -->
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/calendario/show.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/admin/calendario/show.js') }}"></script>
@endpush

</x-dynamic-component>