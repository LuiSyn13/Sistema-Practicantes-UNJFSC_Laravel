<?php

namespace App\Http\Controllers;

use App\Models\EvaluacionPractica;
use App\Models\grupo_practica;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class EvaluacionPracticaController extends Controller
{
    //
    public function index(Request $request)
    {
        $id_semestre = session('semestre_actual_id');
        $authUser = auth()->user();

        $ap_now = $authUser->persona->asignacion_persona;

        $request->validate([
            'grupo' => 'nullable|exists:grupo_practica,id',
        ]);

        // Obtener todos los grupos del supervisor (lista para el select)
        $grupos_practica = grupo_practica::where('id_supervisor', $ap_now->id)->get();

        // Selección por defecto: si no se pasa grupo, usar el primer grupo del supervisor (si existe)
        $selected_grupo_id = $request->input('grupo');
        if (!$selected_grupo_id && $grupos_practica->isNotEmpty()) {
            $selected_grupo_id = $grupos_practica->first()->id;
        }

        // Manejo de módulos similar a RevisarController
        $id_modulo = $request->modulo;
        $id_modulo_now = null;

        if ($selected_grupo_id) {
            $gp = grupo_practica::where('id', $selected_grupo_id)->select('id_modulo')->first();
            $id_modulo_now = $gp ? $gp->id_modulo : null;

            if ($id_modulo === null) {
                $id_modulo = $id_modulo_now;
            } else {
                // No permitir seleccionar un módulo mayor al actual del grupo
                if (!is_null($id_modulo_now) && $id_modulo > $id_modulo_now) {
                    $id_modulo = $id_modulo_now;
                }
            }
        } else {
            // Sin grupo seleccionado no mostramos evaluaciones
            $id_modulo = null;
        }

        // Consultar evaluaciones para el módulo seleccionado y los estudiantes del grupo
        $query = EvaluacionPractica::where('id_modulo', $id_modulo)
            ->with([
                'asignacion_persona.persona',
                'asignacion_persona.grupo_estudiante.grupo_practica',
                'evaluacion_archivo.archivos'
            ]);

        if ($selected_grupo_id) {
            $query->whereHas('asignacion_persona.grupo_estudiante', function ($q) use ($selected_grupo_id) {
                $q->where('id_grupo_practica', $selected_grupo_id);
            });
        }

        $grupo_estudiante = $query->get();

        return view('EvaluacionPractica.index', compact('grupos_practica', 'grupo_estudiante', 'selected_grupo_id', 'id_modulo_now'));
    }

    public function getEvaluacionPractica($id_ap, $id_modulo, $anexo)
    {
        $query = EvaluacionPractica::where('id_modulo', $id_modulo)
            ->where('id_ap', $id_ap);
        $evaluacionPractica = $query->with([
            'evaluacion_archivo' => function ($query) use ($anexo) {
                $query->whereHas('archivos', function ($subQuery) use ($anexo) {
                    $subQuery->where('tipo', $anexo);
                })
                ->with(['archivos' => function ($subQuery) use ($anexo) {
                    $subQuery->where('tipo', $anexo);
                }])
                ->orderBy('created_at', 'desc');
            }
        ])->get();
        Log::info('Modulo: '.$id_modulo);
        //Log::info('evaluacionPractica: ', $evaluacionPractica->toArray());
        return response()->json($evaluacionPractica);
    }
}
