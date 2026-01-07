@extends('layouts.admin')

@section('title', 'Reportes y Estadísticas')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/reportes/index.css') }}">
@endsection

@section('content')
<div class="reportes-container">
    <div class="page-header">
        <div class="header-content">
            <div class="icon-wrapper">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="title-section">
                <h1>Centro de Reportes</h1>
                <p>Generación y visualización de estadísticas del sistema</p>
            </div>
        </div>
        <div class="header-actions">
            <button class="btn-primary-action">
                <i class="fas fa-cog"></i>
                <span>Configurar</span>
            </button>
            <button class="btn-primary-action" style="margin-left: 0.5rem;">
                <i class="fas fa-file-export"></i>
                <span>Exportar Todo</span>
            </button>
        </div>
    </div>

    <div class="reports-grid">
        <!-- Reporte de Estudiantes -->
        <div class="report-card">
            <div class="card-icon students">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="card-content">
                <h3>Estudiantes</h3>
                <p>Reportes de inscripciones, asistencia y rendimiento académico.</p>
                <div class="card-actions">
                    <a href="{{ route('reportes.estudiantes') }}" class="btn-report students">
                        <span>Ver Reportes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <button class="btn-quick-export" title="Exportar General PDF">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Reporte de Docentes -->
        <div class="report-card">
            <div class="card-icon teachers">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="card-content">
                <h3>Docentes</h3>
                <p>Listados, asignaciones de carga horaria y evaluaciones.</p>
                <div class="card-actions">
                    <a href="{{ route('reportes.docentes') }}" class="btn-report teachers">
                        <span>Ver Reportes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <button class="btn-quick-export" title="Exportar General PDF">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Reporte de Calificaciones -->
        <div class="report-card">
            <div class="card-icon grades">
                <i class="fas fa-star"></i>
            </div>
            <div class="card-content">
                <h3>Calificaciones</h3>
                <p>Promedios, boletines y actas de notas por curso.</p>
                <div class="card-actions">
                    <a href="{{ route('reportes.calificaciones') }}" class="btn-report grades">
                        <span>Ver Reportes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <button class="btn-quick-export" title="Exportar General PDF">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Reporte de Materias -->
        <div class="report-card">
            <div class="card-icon subjects">
                <i class="fas fa-book"></i>
            </div>
            <div class="card-content">
                <h3>Materias y Cursos</h3>
                <p>Estadísticas de materias, avance curricular y cursos.</p>
                <div class="card-actions">
                    <a href="{{ route('reportes.materias') }}" class="btn-report subjects">
                        <span>Ver Reportes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <button class="btn-quick-export" title="Exportar General PDF">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Reporte de Asistencia -->
        <div class="report-card">
            <div class="card-icon attendance">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="card-content">
                <h3>Asistencia</h3>
                <p>Registros de asistencia, faltas y justificaciones.</p>
                <div class="card-actions">
                    <a href="#" class="btn-report attendance">
                        <span>Ver Reportes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <button class="btn-quick-export" title="Exportar General PDF">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Reporte de Usuarios -->
        <div class="report-card">
            <div class="card-icon users">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="card-content">
                <h3>Usuarios</h3>
                <p>Actividad de usuarios, roles y permisos del sistema.</p>
                <div class="card-actions">
                    <a href="#" class="btn-report users">
                        <span>Ver Reportes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <button class="btn-quick-export" title="Exportar General PDF">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Reporte de Biblioteca -->
        <div class="report-card">
            <div class="card-icon library">
                <i class="fas fa-book-reader"></i>
            </div>
            <div class="card-content">
                <h3>Biblioteca</h3>
                <p>Préstamos, devoluciones y estado del inventario.</p>
                <div class="card-actions">
                    <a href="#" class="btn-report library">
                        <span>Ver Reportes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <button class="btn-quick-export" title="Exportar General PDF">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Reporte de Laboratorios -->
        <div class="report-card">
            <div class="card-icon labs">
                <i class="fas fa-flask"></i>
            </div>
            <div class="card-content">
                <h3>Laboratorios</h3>
                <p>Uso de equipos, materiales e incidencias.</p>
                <div class="card-actions">
                    <a href="#" class="btn-report labs">
                        <span>Ver Reportes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <button class="btn-quick-export" title="Exportar General PDF">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/admin/reportes/index.js') }}"></script>
@endsection