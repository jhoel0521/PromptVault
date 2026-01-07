@extends('layouts.admin')

@section('title', 'Nuevo Rol')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/roles/create.css') }}">
@endsection

@section('content')
<div class="create-role-container">
    <!-- Header -->
    <div class="panel-header">
        <div class="header-title">
            <div class="icon-wrapper">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="title-content">
                <h2>Nuevo Rol</h2>
                <p class="subtitle">Definir un nuevo perfil de acceso</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.roles.index') }}" class="btn-secondary-action">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a Lista</span>
            </a>
        </div>
    </div>

    <!-- Main Form -->
    <form action="{{ route('admin.roles.store') }}" method="POST" id="createRoleForm">
        @csrf
        
        <div class="form-content">
            
            <!-- Card 1: Basic Info -->
            <div class="form-card">
                <div class="card-header">
                    <div class="card-header-title">
                        <h3>
                            <i class="fas fa-info-circle"></i>
                            Información Básica
                        </h3>
                        <p>Datos principales del rol</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre del Rol <span>*</span></label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card"></i>
                        <input type="text" id="nombre" name="nombre" class="form-input" placeholder="Ej: Gestor de Laboratorios" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <div class="input-wrapper">
                        <i class="fas fa-align-left" style="top: 1rem;"></i>
                        <textarea id="descripcion" name="descripcion" class="form-textarea" rows="3" placeholder="Breve descripción de las responsabilidades de este rol..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Card 2: Permissions -->
            <div class="form-card">
                <div class="card-header">
                    <div class="card-header-title">
                        <h3>
                            <i class="fas fa-key"></i>
                            Permisos del Sistema
                        </h3>
                        <p>Seleccione los accesos permitidos</p>
                    </div>
                </div>

                <div class="permissions-grid">
                    @foreach($permisosGrouped as $modulo => $permisos)
                        <div class="module-card">
                            <div class="module-header">
                                <span class="module-title">{{ ucfirst($modulo) }}</span>
                                <button type="button" class="select-all-btn">Seleccionar Todo</button>
                            </div>
                            <div class="module-permissions">
                                @foreach($permisos as $permiso)
                                    <div class="permission-item">
                                        <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}" id="permiso_{{ $permiso->id }}" class="permission-checkbox">
                                        <label for="permiso_{{ $permiso->id }}" class="permission-label">{{ $permiso->nombre }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-actions">
                    <div class="form-status-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Configurando Accesos</span>
                    </div>
                    <div class="action-buttons">
                        <a href="{{ route('admin.roles.index') }}" class="btn-cancel">Cancelar</a>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i>
                            <span>Guardar Rol</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
@section('js')
<script src="{{ asset('js/admin/roles/create.js') }}"></script>
@endsection
