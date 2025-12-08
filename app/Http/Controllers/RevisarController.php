<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\grupo_practica;
use App\Models\grupo_estudiante;
use App\Models\EvaluacionPractica;
use Illuminate\Support\Facades\Log;

class RevisarController extends Controller
{
    //
    public function index(Request $request)
    {
        $request->validate([
            'grupo' => 'nullable|exists:grupo_practica,id',

        ]);

        $id_semestre = session('semestre_actual_id');
        $authUser = auth()->user();

        $ap_now = $authUser->persona->asignacion_persona;

        $grupos_practica = grupo_practica::where('id_docente', $ap_now->id)->get();

        // calcular el id_modulo actual con evaluacion practica 1, 2, 3, ver el mayor id_modulo en la tabla evaluacion_practica
        // $id_modulo_now = EvaluacionPractica::max('id_modulo');
        Log::info('ACHO');

        $selected_grupo_id = $request->input('grupo');
        $id_modulo = $request->modulo;
        $id_modulo_now = 0; // Por defecto, ningún módulo está activo (todo bloqueado).

        Log::info('id_modulo ARRIBA: '.$id_modulo);

        if ($selected_grupo_id) {
            $gp = grupo_practica::where('id', $selected_grupo_id)->select('id_modulo')->first();
            $id_modulo_now = $gp->id_modulo;

            // Si el usuario no ha seleccionado un módulo, mostramos el más reciente del grupo.
            if ($id_modulo === null) {
                $id_modulo = $id_modulo_now;
            } else {
                // Si el usuario intenta acceder a un módulo futuro, lo limitamos al módulo actual del grupo.
                $id_modulo = ($id_modulo > $id_modulo_now) ? $id_modulo_now : $id_modulo;
            }

        } else {
            // Si no hay grupo seleccionado, no se muestra ninguna evaluación.
            $id_modulo = null;
        }

        Log::info('id_modulo: '.$id_modulo);
        // 1. Iniciar la consulta desde EvaluacionPractica para el módulo seleccionado.
        $query = EvaluacionPractica::where('id_modulo', $id_modulo)
            ->with([
                'asignacion_persona.persona', // Cargar la persona del estudiante.
                'asignacion_persona.grupo_estudiante.grupo_practica' // Cargar el grupo para mostrar su nombre.
            ]);

        if ($selected_grupo_id) {
            $query->whereHas('asignacion_persona.grupo_estudiante', function ($q) use ($selected_grupo_id) {
                $q->where('id_grupo_practica', $selected_grupo_id);
            });
        }

        $grupo_estudiante = $query->get();
        //Log::info('Grupo Estudiantes: ', $grupo_estudiante->toArray());
        Log::info('Número de registros de grupo_estudiante recuperados: ' . $grupo_estudiante->count());

        return view('revisar.index', compact('grupos_practica', 'grupo_estudiante', 'selected_grupo_id', 'id_modulo_now'));
    }
}
