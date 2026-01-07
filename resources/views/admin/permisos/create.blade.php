@extends('layouts.admin')

@section('title', 'Nuevo Permiso')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/permisos/create.css') }}">
@endsection

@section('content')
<div class="create-permiso-container">
    <!-- Header -->
    <div class="panel-header">
        <div class="header-title">
            <div class="icon-wrapper">
                <i class="fas fa-key"></i>
            </div>
            <div class="title-content">
                <h2>Nuevo Permiso</h2>
                <p class="subtitle">Registrar una nueva regla de acceso</p>
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
    <form action="{{ route('admin.permisos.store') }}" method="POST" id="createPermisoForm">
        @csrf
        
        <div class="form-content">
            
            <!-- Left Column: Guidelines -->
            <div class="left-column">
                <div class="help-cards-list">
                    <div class="help-card-item">
                        <div class="help-icon">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div class="help-text">
                            <h4>Módulo</h4>
                            <p>Agrupa el permiso bajo una función (ej: Docentes, Reportes).</p>
                        </div>
                    </div>
                    <div class="help-card-item">
                        <div class="help-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="help-text">
                            <h4>Acción</h4>
                            <p>Verbo que describe la capacidad (ej: crear, editar, eliminar).</p>
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
                                <input type="text" id="nombre" name="nombre" class="form-input" placeholder="ej: docentes.crear" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="modulo">Módulo <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-cubes"></i>
                                <input type="text" list="modulos-list" id="modulo" name="modulo" class="form-input" placeholder="Seleccione o escriba..." required>
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
                                <input type="text" list="acciones-list" id="accion" name="accion" class="form-input" placeholder="Seleccione o escriba..." required>
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
                                <textarea id="descripcion" name="descripcion" class="form-textarea" placeholder="Describa qué permite hacer este permiso..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="form-status-badge">
                            <i class="fas fa-plus-circle"></i>
                            <span>Nuevo Registro</span>
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('admin.permisos.index') }}" class="btn-cancel">Cancelar</a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i>
                                <span>Guardar Permiso</span>
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
<script src="{{ asset('js/admin/permisos/create.js') }}"></script>
@endsection
