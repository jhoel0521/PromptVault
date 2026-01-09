<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prompt;
use App\Models\Categoria;
use App\Models\Etiqueta;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BuscadorController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $tipos = $request->input('tipos', ['prompts', 'categorias', 'etiquetas', 'usuarios']);
        $orderBy = $request->input('orderBy', 'relevancia');
        
        $resultados = [];
        
        if ($query) {
            // Buscar en Prompts
            if (in_array('prompts', $tipos)) {
                $prompts = Prompt::where('titulo', 'like', "%{$query}%")
                    ->orWhere('contenido', 'like', "%{$query}%")
                    ->orWhere('descripcion', 'like', "%{$query}%")
                    ->limit(10)
                    ->get()
                    ->map(function ($prompt) {
                        return [
                            'id' => $prompt->id,
                            'titulo' => $prompt->titulo,
                            'descripcion' => $prompt->descripcion ?? substr($prompt->contenido, 0, 150) . '...',
                            'tipo' => 'Prompt',
                            'icono' => 'file-alt',
                            'enlace' => route('prompts.show', $prompt->id)
                        ];
                    });
                
                if ($prompts->count() > 0) {
                    $resultados['prompts'] = $prompts;
                }
            }
            
            // Buscar en Categorías
            if (in_array('categorias', $tipos)) {
                $categorias = Categoria::where('nombre', 'like', "%{$query}%")
                    ->orWhere('descripcion', 'like', "%{$query}%")
                    ->limit(10)
                    ->get()
                    ->map(function ($categoria) {
                        return [
                            'id' => $categoria->id,
                            'titulo' => $categoria->nombre,
                            'descripcion' => $categoria->descripcion ?? 'Sin descripción',
                            'tipo' => 'Categoría',
                            'icono' => 'folder',
                            'enlace' => '#'
                        ];
                    });
                
                if ($categorias->count() > 0) {
                    $resultados['categorias'] = $categorias;
                }
            }
            
            // Buscar en Etiquetas
            if (in_array('etiquetas', $tipos)) {
                $etiquetas = Etiqueta::where('nombre', 'like', "%{$query}%")
                    ->limit(10)
                    ->get()
                    ->map(function ($etiqueta) {
                        return [
                            'id' => $etiqueta->id,
                            'titulo' => $etiqueta->nombre,
                            'descripcion' => "Etiqueta del sistema",
                            'tipo' => 'Etiqueta',
                            'icono' => 'tag',
                            'enlace' => '#'
                        ];
                    });
                
                if ($etiquetas->count() > 0) {
                    $resultados['etiquetas'] = $etiquetas;
                }
            }
            
            // Buscar en Usuarios
            if (in_array('usuarios', $tipos) && auth()->user()->hasRole('administrador')) {
                $usuarios = User::where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->limit(10)
                    ->get()
                    ->map(function ($usuario) {
                        return [
                            'id' => $usuario->id,
                            'titulo' => $usuario->name,
                            'descripcion' => $usuario->email,
                            'tipo' => 'Usuario',
                            'icono' => 'user',
                            'enlace' => '#'
                        ];
                    });
                
                if ($usuarios->count() > 0) {
                    $resultados['usuarios'] = $usuarios;
                }
            }
        }
        
        return view('buscador.index', [
            'query' => $query,
            'resultados' => $resultados,
            'total' => collect($resultados)->flatten(1)->count()
        ]);
    }
}
