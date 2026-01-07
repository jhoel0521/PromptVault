@extends('layouts.admin')

@section('title', 'Editar Permiso')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/permisos/edit.css') }}">
@endsection

@section('content')
<div class="edit-permiso-container">
    <!-- Header -->
    <div class="panel-header">
        <div class="header-title">
            <div class="icon-wrapper">
                <i class="fas fa-edit"></i>
            </div>
            <div class="title-content">
                <h2>Editar Permiso</h2>
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

    <!-- Main Form -->
    <form action="{{ route('admin.permisos.update', $permiso->id) }}" method="POST" id="editPermisoForm">
        @csrf
        @method('PUT')
        
        <div class="form-content">
            
            <!-- Left Column: Guidelines -->
            <div class="left-column">
                <div class="help-cards-list">
                    <div class="help-card-item">
                        <div class="help-icon">
                            <i class="fas fa-plug"></i>
                        </div>
                        <div class="help-text">
                            <h4>Roles Activos</h4>
                            <p>Este permiso está asignado actualmente a <strong>{{ $permiso->roles->count() }}</strong> roles.</p>
                        </div>
                    </div>
                     <div class="help-card-item">
                        <div class="help-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="help-text">
                             <h4>Precaución</h4>
                            <p>Modificar el nombre clave puede romper funcionalidades si está en uso en el código.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form -->
            <div class="right-column">
                <div class="form-card">
                    <div class="card-header">
                        <h3>
                            <i class="fas fa-info-circle"></i>
                            Detalles del Permiso
                        </h3>
                        <p>Información técnica</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group span-2">
                            <label for="nombre">Nombre Clave <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-tag"></i>
                                <input type="text" id="nombre" name="nombre" class="form-input" placeholder="ej: docentes.crear" required value="{{ old('nombre', $permiso->nombre) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="modulo">Módulo <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-cubes"></i>
                                <input type="text" list="modulos-list" id="modulo" name="modulo" class="form-input" placeholder="Seleccione o escriba..." required value="{{ old('modulo', $permiso->modulo) }}">
                                <datalist id="modulos-list">
                                    @foreach($modulos as $modulo)
                                        <option value="{{ $modulo }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="accion">Acción <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-bolt"></i>
                                <input type="text" list="acciones-list" id="accion" name="accion" class="form-input" placeholder="Seleccione o escriba..." required value="{{ old('accion', $permiso->accion) }}">
                                <datalist id="acciones-list">
                                    @foreach($acciones as $accion)
                                        <option value="{{ $accion }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="descripcion">Descripción</label>
                            <div class="input-wrapper">
                                <i class="fas fa-align-left"></i>
                                <textarea id="descripcion" name="descripcion" class="form-textarea" placeholder="Describa qué permite hacer este permiso...">{{ old('descripcion', $permiso->descripcion) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="form-status-badge">
                            <i class="fas fa-edit"></i>
                            <span>Modo Edición</span>
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('admin.permisos.index') }}" class="btn-cancel">Cancelar</a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i>
                                <span>Actualizar Permiso</span>
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
<script src="{{ asset('js/admin/permisos/edit.js') }}"></script>
@endsection
