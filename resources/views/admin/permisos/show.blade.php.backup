@extends('layouts.admin')

@section('title', 'Detalle de Permiso')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/permisos/show.css') }}">
@endsection

@section('content')
<div class="show-permiso-container">
    <!-- Header -->
    <div class="panel-header">
        <div class="header-title">
            <div class="icon-wrapper">
                <i class="fas fa-key"></i>
            </div>
            <div class="title-content">
                <h2>Detalles del Permiso</h2>
                <p class="subtitle">{{ $permiso->nombre }}</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.permisos.index') }}" class="btn-secondary-action">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a Lista</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="form-content">
        
        <!-- Left: Details -->
        <div class="left-column">
            <div class="form-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-info-circle"></i>
                        Información General
                    </h3>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nombre Clave</span>
                        <div class="info-value">{{ $permiso->nombre }}</div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Módulo</span>
                        <div>
                            <span class="info-badge">{{ $permiso->modulo }}</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Acción</span>
                        <div class="info-value">{{ $permiso->accion }}</div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Descripción</span>
                        <div class="info-value" style="min-height: 80px;">{{ $permiso->descripcion }}</div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.permisos.edit', $permiso->id) }}" class="btn-edit-action">
                        <i class="fas fa-edit"></i>
                        <span>Editar Permiso</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right: Roles -->
        <div class="right-column">
             <div class="form-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-user-shield"></i>
                        Roles con este Permiso
                    </h3>
                    <p>Perfiles que tienen habilitado este acceso</p>
                </div>

                <div class="roles-list">
                    @forelse($permiso->roles as $rol)
                        <div class="role-item">
                            <span class="role-name">{{ $rol->nombre }}</span>
                            <span class="role-users">{{ $rol->usuarios->count() }} Usuarios</span>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            <i class="fas fa-unlink" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                            <p>Este permiso no está asignado a ningún rol.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/admin/permisos/show.js') }}"></script>
@endsection
