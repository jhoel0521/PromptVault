@extends('layouts.admin')

@section('title', 'Nuevo Usuario')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios/create.css') }}">
@endsection

@section('content')
<div class="create-usuario-container">
    <!-- Header -->
    <div class="panel-header">
        <div class="header-title">
            <div class="icon-wrapper">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="title-content">
                <h2>Nuevo Usuario</h2>
                <p class="subtitle">Registre un nuevo usuario en el sistema</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.usuarios.index') }}" class="btn-secondary-action">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a la lista</span>
            </a>
        </div>
    </div>

    <!-- Main Form -->
    <form action="{{ route('admin.usuarios.store') }}" method="POST" enctype="multipart/form-data" id="createUsuarioForm">
        @csrf
        
        <div class="form-content">
            <!-- Left Column: Avatar & Help -->
            <div class="left-column">
                <!-- Avatar Card -->
                <div class="form-card profile-card">
                    <div class="photo-preview-container">
                         <!-- Placeholder or Default Image -->
                        <div class="photo-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                        <img src="" alt="Vista previa" class="photo-preview" style="display: none;">
                    </div>
                    
                    <div class="photo-upload-btn-wrapper">
                        <button type="button" class="btn-upload-photo">
                            <i class="fas fa-camera"></i>
                            Subir Foto
                        </button>
                        <input type="file" name="avatar" id="avatar" class="file-input" accept="image/*">
                    </div>
                    <p class="photo-help-text">JPG, PNG o GIF. Máx 2MB</p>
                </div>

                <!-- Help/Status Cards -->
                <div class="help-section-container">
                    <div class="help-cards-list">
                        <div class="help-card-item">
                            <div class="help-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="help-text">
                                <h4>Rol de Usuario</h4>
                                <p>Define los permisos de acceso.</p>
                            </div>
                        </div>
                        <div class="help-card-item">
                            <div class="help-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="help-text">
                                <h4>Seguridad</h4>
                                <p>Asigne una contraseña segura.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form Sections -->
            <div class="right-column">
                
                <!-- Card 1: User Info -->
                <div class="form-card">
                    <div class="card-header">
                        <h3>
                            <i class="fas fa-address-card"></i>
                            Información Personal
                        </h3>
                        <p>Datos básicos del usuario</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group span-2">
                            <label for="name">Nombre(s) <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" id="name" name="name" class="form-input" placeholder="Ej: Juan" required>
                            </div>
                        </div>

                         <div class="form-group span-2">
                            <label for="apellido">Apellido(s) <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" id="apellido" name="apellido" class="form-input" placeholder="Ej: Pérez" required>
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="ci">Cédula de Identidad</label>
                            <div class="input-wrapper">
                                <i class="fas fa-id-card"></i>
                                <input type="text" id="ci" name="ci" class="form-input" placeholder="Número de CI">
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <div class="input-wrapper">
                                <i class="fas fa-calendar"></i>
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-input">
                            </div>
                        </div>
                        
                        <div class="form-group span-2">
                            <label for="genero">Género</label>
                            <div class="input-wrapper">
                                <i class="fas fa-venus-mars"></i>
                                <select id="genero" name="genero" class="form-select">
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group span-2">
                            <label for="telefono">Teléfono / Celular</label>
                            <div class="input-wrapper">
                                <i class="fas fa-phone"></i>
                                <input type="text" id="telefono" name="telefono" class="form-input" placeholder="+591 ...">
                            </div>
                        </div>
                        
                        <div class="form-group span-4">
                            <label for="direccion">Dirección</label>
                            <div class="input-wrapper">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" id="direccion" name="direccion" class="form-input" placeholder="Av. Principal #123">
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
                        <p>Credenciales y Acceso</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group span-2">
                            <label for="email">Correo Electrónico <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" class="form-input" placeholder="usuario@ejemplo.com" required>
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="password">Contraseña <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password" class="form-input" placeholder="********" required>
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="rol">Rol en el Sistema <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user-tag"></i>
                                <select id="rol" name="rol" class="form-select" required>
                                    <option value="" disabled selected>Seleccione un rol...</option>
                                    <option value="admin">Administrador</option>
                                    <option value="docente">Docente</option>
                                    <option value="estudiante">Estudiante</option>
                                    <option value="padre">Padre/Tutor</option>
                                    <option value="secretaria">Secretaria/o</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="estado">Estado</label>
                            <div class="input-wrapper">
                                <i class="fas fa-toggle-on"></i>
                                <select id="estado" name="estado" class="form-select">
                                    <option value="activo" selected>Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="form-status-badge">
                            <i class="fas fa-user-clock"></i>
                            <span>Nuevo Registro</span>
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('admin.usuarios.index') }}" class="btn-cancel">Cancelar</a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i>
                                <span>Guardar Usuario</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
@section('js')
<script src="{{ asset('js/admin/usuarios/create.js') }}"></script>
@endsection