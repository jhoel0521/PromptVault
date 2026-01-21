<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccesoCompartido;
use App\Models\Etiqueta;
use App\Models\Evento;
use App\Models\Prompt;
use App\Models\User;
use App\Models\Version;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Stats generales
        $totalPrompts = Prompt::count();
        $totalEventos = Evento::count();
        $totalUsuarios = User::where('cuenta_activa', true)->count();
        $totalCompartidos = AccesoCompartido::distinct('prompt_id')->count();

        return view('admin.reportes.index', compact(
            'totalPrompts',
            'totalEventos',
            'totalUsuarios',
            'totalCompartidos'
        ));
    }

    /**
     * Reporte de Prompts
     */
    public function prompts()
    {
        // Stats
        $totalPrompts = Prompt::count();
        $totalEtiquetas = Etiqueta::count();
        $totalVersiones = Version::count();
        $totalCompartidos = Prompt::where('visibilidad', 'publico')->count();

        // Top 10 Prompts con más versiones
        $topPrompts = Prompt::with(['user', 'versiones'])
            ->withCount('versiones')
            ->orderBy('versiones_count', 'desc')
            ->take(10)
            ->get();

        // Chart: Prompts por Mes (últimos 6 meses)
        $chartMeses = [];
        $chartPromptsData = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $chartMeses[] = ucfirst($fecha->translatedFormat('M'));
            $chartPromptsData[] = Prompt::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
        }

        // Chart: Top 10 Etiquetas
        $etiquetas = Etiqueta::withCount('prompts')
            ->orderBy('prompts_count', 'desc')
            ->take(10)
            ->get();
        $chartEtiquetasLabels = $etiquetas->pluck('nombre')->toArray();
        $chartEtiquetasData = $etiquetas->pluck('prompts_count')->toArray();

        // Chart: Top 5 Prompts con más versiones
        $topVersiones = Prompt::withCount('versiones')
            ->orderBy('versiones_count', 'desc')
            ->take(5)
            ->get();
        $chartVersionesLabels = $topVersiones->pluck('titulo')->map(fn ($t) => Str::limit($t, 20))->toArray();
        $chartVersionesData = $topVersiones->pluck('versiones_count')->toArray();

        // Chart: Privados vs Compartidos
        $privados = Prompt::where('visibilidad', 'privado')->count();
        $compartidos = Prompt::where('visibilidad', 'publico')->count();
        $chartVisibilidadData = [$privados, $compartidos];

        return view('admin.reportes.prompts', compact(
            'totalPrompts',
            'totalEtiquetas',
            'totalVersiones',
            'totalCompartidos',
            'topPrompts',
            'chartMeses',
            'chartPromptsData',
            'chartEtiquetasLabels',
            'chartEtiquetasData',
            'chartVersionesLabels',
            'chartVersionesData',
            'chartVisibilidadData'
        ));
    }

    /**
     * Reporte de Eventos
     */
    public function eventos()
    {
        // Stats
        $totalEventos = Evento::count();
        $eventosCompletados = Evento::where('completado', true)->count();
        $eventosPendientes = Evento::where('completado', false)->count();
        $tasaCompletado = $totalEventos > 0 ? round(($eventosCompletados / $totalEventos) * 100) : 0;

        // Chart: Eventos por Mes (últimos 6 meses)
        $chartMeses = [];
        $chartEventosData = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $chartMeses[] = ucfirst($fecha->translatedFormat('M'));
            $chartEventosData[] = Evento::whereYear('fecha_inicio', $fecha->year)
                ->whereMonth('fecha_inicio', $fecha->month)
                ->count();
        }

        // Chart: Eventos por Tipo
        $tipoStats = Evento::select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->get();
        $chartTiposLabels = $tipoStats->pluck('tipo')->map(fn ($t) => ucfirst($t->value))->toArray();
        $chartTiposData = $tipoStats->pluck('total')->toArray();

        // Chart: Completados vs Pendientes
        $chartEstadoData = [$eventosCompletados, $eventosPendientes];

        // Chart: Eventos por Día de la Semana
        $diasStats = [];
        for ($dia = 1; $dia <= 7; $dia++) {
            $diasStats[] = Evento::whereRaw('DAYOFWEEK(fecha_inicio) = ?', [$dia])->count();
        }
        $chartDiasData = $diasStats;

        return view('admin.reportes.eventos', compact(
            'totalEventos',
            'eventosCompletados',
            'eventosPendientes',
            'tasaCompletado',
            'chartMeses',
            'chartEventosData',
            'chartTiposLabels',
            'chartTiposData',
            'chartEstadoData',
            'chartDiasData'
        ));
    }
}
