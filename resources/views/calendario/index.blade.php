<x-app-layout :title="'Mi Calendario - PromptVault'">
    @push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <style>
        /* FullCalendar Dark Mode */
        .dark .fc {
            --fc-border-color: rgb(51 65 85);
            --fc-button-text-color: #fff;
            --fc-button-bg-color: rgb(225 29 72);
            --fc-button-border-color: rgb(225 29 72);
            --fc-button-hover-bg-color: rgb(190 24 93);
            --fc-button-hover-border-color: rgb(190 24 93);
            --fc-button-active-bg-color: rgb(159 18 57);
            --fc-button-active-border-color: rgb(159 18 57);
            --fc-page-bg-color: rgb(30 41 59);
            --fc-neutral-bg-color: rgb(51 65 85);
            --fc-today-bg-color: rgba(225, 29, 72, 0.1);
            color: rgb(226 232 240);
        }
        .dark .fc .fc-toolbar-title { color: rgb(248 250 252); }
        .dark .fc .fc-col-header-cell { background-color: rgb(51 65 85); border-color: rgb(51 65 85); }
        .dark .fc-theme-standard td, .dark .fc-theme-standard th { border-color: rgb(51 65 85); }
        .dark .fc .fc-daygrid-day-number { color: rgb(226 232 240); }
        .dark .fc .fc-list-day-cushion { background-color: rgb(51 65 85); }
        
        /* FullCalendar Light Mode */
        .fc {
            --fc-button-text-color: #fff;
            --fc-button-bg-color: rgb(225 29 72);
            --fc-button-border-color: rgb(225 29 72);
            --fc-button-hover-bg-color: rgb(190 24 93);
            --fc-button-hover-border-color: rgb(190 24 93);
            --fc-button-active-bg-color: rgb(159 18 57);
            --fc-button-active-border-color: rgb(159 18 57);
            --fc-today-bg-color: rgba(225, 29, 72, 0.1);
        }
        .fc .fc-event { border: none; padding: 2px 4px; cursor: pointer; }
        .fc .fc-button { text-transform: capitalize; }
        .fc .fc-button-primary:focus { box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.2); }
    </style>
    @endpush>
    <div class="max-w-7xl mx-auto px-6 py-10">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                    <i class="fas fa-calendar-alt text-rose-600"></i>
                    Mi Calendario
                </h1>
                <p class="text-slate-600 dark:text-slate-400 mt-2">
                    Organiza tus eventos y recordatorios
                </p>
            </div>
            <a href="{{ route('calendario.create') }}" 
               class="bg-rose-600 hover:bg-rose-700 text-white font-bold px-6 py-3 rounded-lg shadow-lg shadow-rose-500/20 transition-colors inline-flex items-center gap-2">
                <i class="fas fa-plus"></i> Nuevo Evento
            </a>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Total Eventos</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $totalEventos ?? 0 }}</p>
                    </div>
                    <div class="bg-rose-100 dark:bg-rose-900/20 p-3 rounded-lg">
                        <i class="fas fa-calendar text-rose-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Este Mes</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $eventosMes ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 dark:bg-blue-900/20 p-3 rounded-lg">
                        <i class="fas fa-calendar-week text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Próximos 7 días</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $eventosSemana ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900/20 p-3 rounded-lg">
                        <i class="fas fa-calendar-day text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Hoy</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $eventosHoy ?? 0 }}</p>
                    </div>
                    <div class="bg-amber-100 dark:bg-amber-900/20 p-3 rounded-lg">
                        <i class="fas fa-clock text-amber-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Calendario FullCalendar --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-6 shadow-lg">
            <div id="calendar"></div>
        </div>

        {{-- Próximos Eventos --}}
        @if(!empty($proximosEventos) && count($proximosEventos) > 0)
        <div class="mt-8 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-6 shadow-lg">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fas fa-bell text-rose-600"></i>
                Próximos Eventos
            </h3>
            <div class="space-y-3">
                @foreach($proximosEventos as $evento)
                <a href="{{ route('calendario.show', $evento) }}" 
                   class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-900 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors group">
                    <div class="flex items-center gap-4">
                        <div class="bg-rose-100 dark:bg-rose-900/20 p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-day text-rose-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-white">{{ $evento->titulo }}</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                <i class="fas fa-clock text-xs mr-1"></i>
                                {{ $evento->fecha_inicio->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-slate-400 group-hover:text-rose-600 transition-colors"></i>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const eventos = @json($eventos ?? []);
    
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día',
            list: 'Lista'
        },
        height: 'auto',
        navLinks: true,
        editable: false,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        events: eventos.map(e => ({
            id: e.id,
            title: e.titulo,
            start: e.fecha_inicio,
            end: e.fecha_fin,
            backgroundColor: getTipoColor(e.tipo),
            borderColor: getTipoColor(e.tipo),
            extendedProps: {
                descripcion: e.descripcion,
                tipo: e.tipo,
                ubicacion: e.ubicacion
            }
        })),
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            window.location.href = `/calendario/${info.event.id}`;
        },
        dateClick: function(info) {
            window.location.href = `/calendario/create?fecha=${info.dateStr}`;
        }
    });
    
    calendar.render();
    
    function getTipoColor(tipo) {
        const colores = {
            'trabajo': '#ef4444',
            'personal': '#3b82f6',
            'estudio': '#10b981',
            'reunion': '#a855f7',
            'recordatorio': '#f59e0b'
        };
        return colores[tipo] || '#6b7280';
    }
});
</script>
</x-app-layout>
