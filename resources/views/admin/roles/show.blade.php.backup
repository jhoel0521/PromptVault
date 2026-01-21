@extends('layouts.admin')

@section('title', 'Detalle de Rol')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/roles/show.css') }}">
@endsection

@section('content')
<div class="show-role-container">
    <!-- Header -->
    <div class="panel-header">
        <div class="header-title">
            <div class="icon-wrapper">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="title-content">
                <h2>Detalles del Rol</h2>
                <p class="subtitle">{{ $role->nombre }}</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.roles.index') }}" class="btn-secondary-action">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a Lista</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="form-content">
        
        <!-- Card 1: Basic Info -->
        <div class="form-card">
            <div class="card-header">
                <div class="card-header-title">
                    <h3>
                        <i class="fas fa-info-circle"></i>
                        Información General
                    </h3>
                </div>
                @if($role->es_sistema)
                    <div style="background: rgba(59, 130, 246, 0.1); padding: 0.5rem 1rem; border-radius: 8px; color: #3b82f6; font-size: 0.85rem; font-weight: 600;">
                        <i class="fas fa-server"></i> Rol de Sistema
                    </div>
                @endif
            </div>

            <div class="role-info-grid">
                <div class="info-group">
                    <span class="info-label">Nombre del Rol</span>
                    <span class="info-value">{{ $role->nombre }}</span>
                </div>
                <div class="info-group">
                    <span class="info-label">Usuarios Asignados</span>
                    <span class="info-value">{{ $role->usuarios->count() }} Usuarios</span>
                </div>
                <div class="role-description">
                    <strong>Descripción:</strong><br>
                    {{ $role->descripcion ?? 'Sin descripción definida.' }}
                </div>
            </div>
        </div>

        <!-- Card 2: Permissions -->
        <div class="form-card">
            <div class="card-header">
                <div class="card-header-title">
                    <h3>
                        <i class="fas fa-key"></i>
                        Permisos Concedidos
                    </h3>
                    <p>Accesos habilitados para este perfil</p>
                </div>
            </div>

            <div class="permissions-grid">
                @php
                    $permissions = $role->permisos;
                    $groupedPermissions = $permissions->groupBy('modulo');
                @endphp

                @forelse($groupedPermissions as $modulo => $moduloPermissions)
                    <div class="module-card">
                        <div class="module-header">
                            <span class="module-title">{{ ucfirst($modulo) }}</span>
                            <span class="module-count">{{ $moduloPermissions->count() }} Permisos</span>
                        </div>
                        <div class="module-permissions">
                            @foreach($moduloPermissions as $permiso)
                                <div class="permission-badge">
                                    <i class="fas fa-check"></i>
                                    {{ $permiso->nombre }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="full-width" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                        <i class="fas fa-lock" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                        <p>Este rol no tiene permisos asignados.</p>
                    </div>
                @endforelse
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn-edit-action">
                    <i class="fas fa-edit"></i>
                    <span>Editar Rol</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/admin/roles/show.js') }}"></script>
@endsection
