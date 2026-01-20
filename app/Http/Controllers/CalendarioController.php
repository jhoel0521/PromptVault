<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = Evento::where('user_id', Auth::id())
            ->orderBy('fecha_inicio')
            ->get();

        $totalEventos = $eventos->count();

        // Eventos del mes actual
        $eventosMes = Evento::where('user_id', Auth::id())
            ->whereYear('fecha_inicio', now()->year)
            ->whereMonth('fecha_inicio', now()->month)
            ->count();

        // Eventos de los próximos 7 días
        $eventosSemana = Evento::where('user_id', Auth::id())
            ->whereBetween('fecha_inicio', [now(), now()->addDays(7)])
            ->count();

        // Eventos de hoy
        $eventosHoy = Evento::where('user_id', Auth::id())
            ->whereDate('fecha_inicio', now())
            ->count();

        // Próximos 5 eventos
        $proximosEventos = Evento::where('user_id', Auth::id())
            ->where('fecha_inicio', '>=', now())
            ->orderBy('fecha_inicio')
            ->limit(5)
            ->get();

        return view('calendario.index', compact('eventos', 'totalEventos', 'eventosMes', 'eventosSemana', 'eventosHoy', 'proximosEventos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('calendario.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|string',
            'ubicacion' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        Evento::create($validated);

        return redirect()->route('calendario.index')->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $evento = Evento::findOrFail($id);

        // Verificar autenticación
        if (! Auth::check()) {
            abort(403, 'Debes estar autenticado para ver eventos');
        }

        // Solo el propietario puede ver el evento
        if ($evento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este evento');
        }

        return view('calendario.show', compact('evento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $evento = Evento::findOrFail($id);

        // Verificar que el evento pertenece al usuario
        if ($evento->user_id !== Auth::id()) {
            abort(403);
        }

        return view('calendario.edit', compact('evento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);

        // Verificar que el evento pertenece al usuario
        if ($evento->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|string',
            'ubicacion' => 'nullable|string|max:255',
        ]);

        $evento->update($validated);

        return redirect()->route('calendario.show', $evento->id)->with('success', 'Evento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);

        // Verificar que el evento pertenece al usuario
        if ($evento->user_id !== Auth::id()) {
            abort(403);
        }

        $evento->delete();

        return redirect()->route('calendario.index')->with('success', 'Evento eliminado exitosamente.');
    }
}
