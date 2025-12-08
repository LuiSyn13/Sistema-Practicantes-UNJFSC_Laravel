<?php

namespace App\Http\Controllers;

use App\Models\Evaluacione;
use App\Models\grupo_estudiante;
use App\Models\Pregunta;
use App\Models\Persona;
use App\Models\asignacion_persona;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EvaluacionController extends Controller
{
    /**
     * Mostrar evaluación para estudiantes asignados al docente o supervisor.
     */
    public function index(Request $request)
{
    $user = auth()->user();
    $userId = $user->id;
    $userRol = $user->getRolId();
    $ap_now = asignacion_persona::where('id_persona', $userId)->first();

    if ($userRol == 1) {
        // Si es admin: ver todos los estudiantes asignados en algún grupo
        $grupoEstudiantes = grupo_estudiante::with([
                'estudiante.seccion_academica.escuela',
                'estudiante.evaluaciones',
                'estudiante.respuestas.pregunta',
                'grupo_practica.docente',
                'grupo_practica.supervisor',
            ])->get();

        $alumnos = $grupoEstudiantes->pluck('estudiante')->unique('id')->values();
    } else {
        // Docente o supervisor: solo sus asignados
        /*$grupoEstudiantes = grupo_estudiante::with([
                'estudiante.asignacion_persona.escuela',
                'estudiante.evaluaciones',
                'estudiante.respuestas.pregunta',
                'grupo_practica.seccion_academica.escuela',
                'grupo_practica.docente.asignacion_persona.persona'
            ])
            ->where(function ($q) use ($userId) {
                $q->where('id_supervisor', $userId)
                  ->orWhereHas('seccion_academica', function ($g) use ($userId) {
                      $g->where('id_docente', $userId);
                  });
            })
            ->get();*/
        $grupoEstudiantes =DB::table('grupo_estudiante as ge')
            ->join('asignacion_persona as ap', 'ge.id_estudiante', '=', 'ap.id')
            ->join('personas as p', 'ap.id_persona', '=', 'p.id')
            ->join('grupo_practica as gp', 'ge.id_grupo_practica', '=', 'gp.id')
            ->where('gp.id_supervisor', $ap_now->id)
            ->select('ge.*', 'p.nombres', 'p.apellidos', 'gp.name as grupo_nombre')
            ->get();

        $alumnos = $grupoEstudiantes->pluck('estudiante')->unique('id')->values();
    }

    // Búsqueda por nombre
    if ($request->filled('buscar')) {
        $alumnos = $alumnos->filter(function ($alumno) use ($request) {
            return stripos($alumno->nombres, $request->buscar) !== false ||
                   stripos($alumno->apellidos, $request->buscar) !== false;
        })->values();
    }

    Log::info('Alumnos obtenidos para evaluación', ['alumnos' => $alumnos->pluck('id')->toArray()]);

    // Preguntas según usuario (solo para docentes/supervisores)
    $preguntas = Pregunta::where('user_create', $userId)
                        ->where('state', true)
                        ->orderBy('id')
                        ->get();

    return view('evaluacion.index', compact('userRol', 'alumnos', 'preguntas'));
}


    /**
     * Guardar o actualizar anexos (6, 7 y 8).
     */
    public function storeAnexos(Request $request)
{
    $request->validate([
        'alumno_id' => 'required|exists:personas,id',
        'anexo_6'   => 'nullable|file|mimes:pdf',
        'anexo_7'   => 'nullable|file|mimes:pdf',
        'anexo_8'   => 'nullable|file|mimes:pdf',
    ]);

    // Buscar al alumno para nombrar los archivos
    $alumno = \App\Models\Persona::findOrFail($request->alumno_id); // Asegúrate de importar el modelo correctamente

    $evaluacion = Evaluacion::firstOrNew(['alumno_id' => $alumno->id]);

    // Función para generar nombres personalizados
    $nombreBase = str_replace(' ', '_', $alumno->nombres . '_' . $alumno->apellidos);

    if ($request->hasFile('anexo_6')) {
        if ($evaluacion->anexo_6) {
            Storage::disk('public')->delete($evaluacion->anexo_6);
        }
        $nombreArchivo = 'anexo_6_' . $nombreBase . '.' . $request->file('anexo_6')->extension();
        $evaluacion->anexo_6 = $request->file('anexo_6')->storeAs('anexos', $nombreArchivo, 'public');
    }

    if ($request->hasFile('anexo_7')) {
        if ($evaluacion->anexo_7) {
            Storage::disk('public')->delete($evaluacion->anexo_7);
        }
        $nombreArchivo = 'anexo_7_' . $nombreBase . '.' . $request->file('anexo_7')->extension();
        $evaluacion->anexo_7 = $request->file('anexo_7')->storeAs('anexos', $nombreArchivo, 'public');
    }

    if ($request->hasFile('anexo_8')) {
        if ($evaluacion->anexo_8) {
            Storage::disk('public')->delete($evaluacion->anexo_8);
        }
        $nombreArchivo = 'anexo_8_' . $nombreBase . '.' . $request->file('anexo_8')->extension();
        $evaluacion->anexo_8 = $request->file('anexo_8')->storeAs('anexos', $nombreArchivo, 'public');
    }

    if (!$evaluacion->exists) {
        $evaluacion->user_create = auth()->user()->name ?? 'admin';
        $evaluacion->date_create = now();
        $evaluacion->estado = true;
    } else {
        $evaluacion->user_update = auth()->user()->name ?? 'admin';
        $evaluacion->date_update = now();
    }

    $evaluacion->save();

    return redirect()->route('evaluacion.index', ['open' => $alumno->id])
                     ->with('success', 'Anexos guardados correctamente.');
}


}
