@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios/edit.css') }}">
@endsection

@section('content')
<div class="edit-usuario-container">
    <!-- Header -->
    <div class="panel-header">
        <div class="header-title">
            <div class="icon-wrapper">
                <i class="fas fa-user-edit"></i>
            </div>
            <div class="title-content">
                <h2>Editar Usuario</h2>
                <p class="subtitle">Actualice los datos del usuario</p>
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
    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data" id="editUsuarioForm">
        @csrf
        @method('PUT')
        
        <div class="form-content">
            <!-- Left Column: Avatar & Help -->
            <div class="left-column">
                <!-- Avatar Card -->
                <div class="form-card profile-card">
                    <div class="photo-preview-container">
                        @if($usuario->avatar)
                            <img src="{{ asset('storage/' . $usuario->avatar) }}" alt="Foto de perfil" class="photo-preview">
                        @else
                            <div class="photo-placeholder" style="{{ $usuario->avatar ? 'display: none;' : '' }}">
                                <i class="fas fa-user"></i>
                            </div>
                            <img src="" alt="Vista previa" class="photo-preview" style="display: none;">
                        @endif
                    </div>
                    
                    <div class="photo-upload-btn-wrapper">
                        <button type="button" class="btn-upload-photo">
                            <i class="fas fa-camera"></i>
                            Cambiar Foto
                        </button>
                        <input type="file" name="avatar" id="avatar" class="file-input" accept="image/*">
                    </div>
                    <p class="photo-help-text">Deje vacío para mantener la actual.</p>
                </div>

                <!-- Help/Status Cards -->
                <div class="help-section-container">
                    <div class="help-cards-list">
                        <div class="help-card-item">
                            <div class="help-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="help-text">
                                <h4>Rol Actual</h4>
                                <p>{{ ucfirst($usuario->rol) }}</p>
                            </div>
                        </div>
                         <div class="help-card-item">
                            <div class="help-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="help-text">
                                <h4>Contraseña</h4>
                                <p>Llenar solo si desea cambiarla.</p>
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
                                <input type="text" id="name" name="name" class="form-input" placeholder="Ej: Juan" required value="{{ old('name', $usuario->name) }}">
                            </div>
                        </div>

                         <div class="form-group span-2">
                            <label for="apellido">Apellido(s) <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" id="apellido" name="apellido" class="form-input" placeholder="Ej: Pérez" required value="{{ old('apellido', $usuario->apellido) }}">
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="ci">Cédula de Identidad</label>
                            <div class="input-wrapper">
                                <i class="fas fa-id-card"></i>
                                <input type="text" id="ci" name="ci" class="form-input" placeholder="Número de CI" value="{{ old('ci', $usuario->ci) }}">
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <div class="input-wrapper">
                                <i class="fas fa-calendar"></i>
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-input" value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento ? $usuario->fecha_nacimiento->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        
                        <div class="form-group span-2">
                            <label for="genero">Género</label>
                            <div class="input-wrapper">
                                <i class="fas fa-venus-mars"></i>
                                <select id="genero" name="genero" class="form-select">
                                    <option value="" disabled>Seleccione...</option>
                                    <option value="M" {{ old('genero', $usuario->genero) == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('genero', $usuario->genero) == 'F' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group span-2">
                            <label for="telefono">Teléfono / Celular</label>
                            <div class="input-wrapper">
                                <i class="fas fa-phone"></i>
                                <input type="text" id="telefono" name="telefono" class="form-input" placeholder="+591 ..." value="{{ old('telefono', $usuario->telefono) }}">
                            </div>
                        </div>
                        
                        <div class="form-group span-4">
                            <label for="direccion">Dirección</label>
                            <div class="input-wrapper">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" id="direccion" name="direccion" class="form-input" placeholder="Av. Principal #123" value="{{ old('direccion', $usuario->direccion) }}">
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
                                <input type="email" id="email" name="email" class="form-input" placeholder="usuario@ejemplo.com" required value="{{ old('email', $usuario->email) }}">
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="password">Contraseña (Opcional)</label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password" class="form-input" placeholder="Dejar vacío para mantener">
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="rol">Rol en el Sistema <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user-tag"></i>
                                <select id="rol" name="rol" class="form-select" required>
                                    <option value="" disabled>Seleccione un rol...</option>
                                    <option value="admin" {{ old('rol', $usuario->rol) == 'admin' ? 'selected' : '' }}>Administrador</option>
                                    <option value="docente" {{ old('rol', $usuario->rol) == 'docente' ? 'selected' : '' }}>Docente</option>
                                    <option value="estudiante" {{ old('rol', $usuario->rol) == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                                    <option value="padre" {{ old('rol', $usuario->rol) == 'padre' ? 'selected' : '' }}>Padre/Tutor</option>
                                    <option value="secretaria" {{ old('rol', $usuario->rol) == 'secretaria' ? 'selected' : '' }}>Secretaria/o</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="estado">Estado</label>
                            <div class="input-wrapper">
                                <i class="fas fa-toggle-on"></i>
                                <select id="estado" name="estado" class="form-select">
                                    <option value="activo" {{ old('estado', $usuario->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado', $usuario->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="form-status-badge">
                            <i class="fas fa-edit"></i>
                            <span>Modo Edición</span>
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('admin.usuarios.index') }}" class="btn-cancel">Cancelar</a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i>
                                <span>Actualizar Usuario</span>
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
<script src="{{ asset('js/admin/usuarios/edit.js') }}"></script>
@endsection