@extends('layouts.admin')

@section('title', 'Gestión de Roles')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/roles/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/paginacion.css') }}">
@endsection

@section('content')
<div class="roles-container">
    <!-- Control Panel Section -->
    <div class="control-panel">
        <div class="panel-header">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-user-tag"></i>
                </div>
                <div class="title-content">
                    <h2>Roles</h2>
                    <p class="subtitle">Gestión de roles y perfiles de acceso al sistema</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.roles.create') }}" class="btn-primary-action">
                    <i class="fas fa-plus"></i>
                    <span>Nuevo Rol</span>
                </a>
            </div>
        </div>

        <div class="panel-content">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Buscar por nombre o descripción..." value="{{ request('search') }}">
            </div>
            
            <div class="filter-group">
                <div class="select-wrapper">
                    <i class="fas fa-filter"></i>
                    <select id="typeSelect">
                        <option value="">Todos los Tipos</option>
                        <option value="sistema" {{ request('tipo') == 'sistema' ? 'selected' : '' }}>Sistema</option>
                        <option value="personalizado" {{ request('tipo') == 'personalizado' ? 'selected' : '' }}>Personalizado</option>
                    </select>
                </div>

                <div class="select-wrapper">
                    <i class="fas fa-list-ol"></i>
                    <select id="entriesSelect">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 por pág.</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 por pág.</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 por pág.</option>
                    </select>
                </div>

                <a href="#" class="btn-primary-action">
                    <i class="fas fa-file-export"></i>
                    <span>Exportar</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Tabla -->
    <div class="table-section">
        <div class="table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Rol</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Usuarios Asignados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $rol)
                        <tr>
                            <td>
                                <div class="role-info">
                                    <span class="name">{{ $rol->nombre }}</span>
                                    <span class="description">{{ Str::limit($rol->descripcion, 50) }}</span>
                                </div>
                            </td>
                            <td>
                                @if($rol->es_sistema)
                                    <span class="badge system">
                                        <i class="fas fa-shield-alt"></i> Sistema
                                    </span>
                                @else
                                    <span class="badge custom">
                                        <i class="fas fa-edit"></i> Personalizado
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge {{ $rol->activo ? 'active' : 'inactive' }}">
                                    {{ $rol->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <div class="users-count">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $rol->usuarios_count }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.roles.show', $rol->id) }}" class="btn-icon view" title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if(!$rol->es_sistema)
                                        <a href="{{ route('admin.roles.edit', $rol->id) }}" class="btn-icon edit" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn-icon delete" onclick="confirmDelete({{ $rol->id }})" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <form id="delete-form-{{ $rol->id }}" action="{{ route('admin.roles.destroy', $rol->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @else
                                        <button type="button" class="btn-icon edit" disabled title="No editable (Sistema)">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center" style="padding: 3rem; color: var(--text-muted);">
                                No se encontraron roles registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="pagination-wrapper">
        {{ $roles->appends(request()->query())->links('pages.roles') }}
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin/roles/index.js') }}"></script>
    <script>
        const swalTheme = {
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            background: '#ffffff',
            color: '#1e293b'
        };
    </script>
@endsection
