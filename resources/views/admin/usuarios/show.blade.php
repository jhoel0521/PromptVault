@extends('layouts.admin')

@section('title', 'Detalle de Usuario')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios/show.css') }}">
@endsection

@section('content')
<div class="show-usuario-container">
    <!-- Header -->
    <div class="panel-header">
        <div class="header-title">
            <div class="icon-wrapper">
                <i class="fas fa-user"></i>
            </div>
            <div class="title-content">
                <h2>Detalles del Usuario</h2>
                <p class="subtitle">{{ $usuario->nombre_completo }}</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.usuarios.index') }}" class="btn-secondary-action">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a la lista</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="form-content">
        <!-- Left Column: Avatar & Status -->
        <div class="left-column">
            <div class="form-card profile-card">
                 <div class="photo-preview-container">
                    @if($usuario->avatar)
                        <img src="{{ asset('storage/' . $usuario->avatar) }}" alt="Foto de perfil" class="photo-preview">
                    @else
                        <div class="photo-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                
                <h3 style="color: white; margin-top: 1rem;">{{ ucfirst($usuario->rol) }}</h3>
                <span style="color: var(--text-muted);">{{ $usuario->email }}</span>

                <!-- Quick Stats -->
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Estado</span>
                        <span class="info-value" style="color: {{ $usuario->estado == 'activo' ? '#4ade80' : '#f87171' }};">
                            {{ ucfirst($usuario->estado) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Data -->
        <div class="right-column">
            
            <!-- Card 1: Personal Info -->
            <div class="form-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-address-card"></i>
                        Información Personal
                    </h3>
                </div>

                <div class="form-grid">
                    <div class="form-group span-2">
                        <label>Nombre(s)</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" class="form-input" value="{{ $usuario->name }}" readonly>
                        </div>
                    </div>

                    <div class="form-group span-2">
                        <label>Apellido(s)</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" class="form-input" value="{{ $usuario->apellido }}" readonly>
                        </div>
                    </div>

                    <div class="form-group span-2">
                        <label>Cédula de Identidad</label>
                        <div class="input-wrapper">
                            <i class="fas fa-id-card"></i>
                            <input type="text" class="form-input" value="{{ $usuario->ci }}" readonly>
                        </div>
                    </div>

                    <div class="form-group span-2">
                        <label>Fecha de Nacimiento</label>
                        <div class="input-wrapper">
                            <i class="fas fa-calendar"></i>
                            <input type="text" class="form-input" value="{{ $usuario->fecha_nacimiento ? $usuario->fecha_nacimiento->format('d/m/Y') : '-' }}" readonly>
                        </div>
                    </div>

                    <div class="form-group span-2">
                        <label>Género</label>
                        <div class="input-wrapper">
                            <i class="fas fa-venus-mars"></i>
                            <input type="text" class="form-input" value="{{ $usuario->genero == 'M' ? 'Masculino' : ($usuario->genero == 'F' ? 'Femenino' : '') }}" readonly>
                        </div>
                    </div>

                    <div class="form-group span-2">
                        <label>Teléfono</label>
                        <div class="input-wrapper">
                            <i class="fas fa-phone"></i>
                            <input type="text" class="form-input" value="{{ $usuario->telefono }}" readonly>
                        </div>
                    </div>

                     <div class="form-group span-4">
                        <label>Dirección</label>
                        <div class="input-wrapper">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" class="form-input" value="{{ $usuario->direccion }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card 2: Account Info -->
            <div class="form-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-user-shield"></i>
                        Datos de Cuenta
                    </h3>
                </div>

                <div class="form-grid">
                    <div class="form-group span-2">
                        <label>Correo Electrónico</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="form-input" value="{{ $usuario->email }}" readonly>
                        </div>
                    </div>

                    <div class="form-group span-2">
                        <label>Rol</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user-tag"></i>
                            <input type="text" class="form-input" value="{{ ucfirst($usuario->rol) }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn-edit-action">
                        <i class="fas fa-edit"></i>
                        <span>Editar Usuario</span>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/admin/usuarios/show.js') }}"></script>
@endsection