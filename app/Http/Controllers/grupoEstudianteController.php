<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\Facultad;
use App\Models\grupo_estudiante;
use App\Models\grupo_practica;
use App\Models\EvaluacionPractica;
use App\Models\Persona;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class grupoEstudianteController extends Controller
{
    public function index()
    {
        $id = auth()->id(); 
        if($id == 1){
            $grupos_practica = grupo_practica::all();
        }else{
            $grupos_practica = grupo_practica::where('id_docente',$id )->get();
        }

        $semestre = session('semestre_actual_id');

        $gp = grupo_practica::with([
            'docente.persona',
            'supervisor.persona',
            'seccion_academica' => function($query) use ($semestre) {
                $query->where('id_semestre', $semestre);
            },
            'grupo_estudiante.estudiante.persona'
        ])->get();

        //$docentes = Persona::where('rol_id', 3)->get(); // Ajusta rol_id si es necesario
        $docentes = Persona::whereHas('asignacion_persona', function ($query) {
            $query->where('id_rol', 3);
        })->get();
        $supervisoresAsignados = DB::table('grupo_estudiante')
            ->select('id_estudiante')
            ->distinct()
            ->pluck('id_estudiante');

        /*$docente2 = Persona::where('rol_id', 3)
            ->whereNotIn('id', $supervisoresAsignados)
            ->get();*/
        $docente2 = Persona::whereHas('asignacion_persona', function ($query) use ($supervisoresAsignados) {
            $query->where('id_rol', 3)
                  ->whereNotIn('id_persona', $supervisoresAsignados);
        })->get();

        $semestres = Semestre::all();
        $escuelas = Escuela::all();
        $facultades = Facultad::all();
        
        //$estudiantes = Persona::with(relations: 'escuela')->get();
        $estudiantes = Persona::whereHas('asignacion_persona', function ($query) {
            $query->where('id_rol', 5);
        })->get();

        return view('asignatura.grupoAsignatura', compact(
            'gp',
            'docentes','docente2',
            'semestres',
            'escuelas',
            'facultades',
            'grupos_practica',
            'estudiantes'
        ));
    }


    public function asignarAlumnos(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupo_practica,id',
            'estudiantes' => 'required|array',
            'estudiantes.*' => 'exists:asignacion_persona,id', // Validar que cada ID de estudiante exista en asignacion_persona
        ]);

        $grupoId = $request->grupo_id;
        $estudiantesIds = $request->estudiantes;
        $asignadosCount = 0;

        foreach ($estudiantesIds as $estudianteApId) {
            // Usamos firstOrCreate para evitar duplicados.
            // Si la combinación de grupo y estudiante ya existe, no hace nada.
            // Si no existe, la crea.
            $asignacion = grupo_estudiante::firstOrCreate([
                'id_grupo_practica' => $grupoId,
                'id_estudiante' => $estudianteApId, // El ID del estudiante es el ID de asignacion_persona
            ]);

            // Si el estudiante fue recién asignado, creamos sus 4 registros de evaluación.
            if ($asignacion->wasRecentlyCreated) {
                $asignadosCount++;
                // Crear los 4 módulos en estado pendiente para el estudiante.
                for ($i = 1; $i <= 4; $i++) {
                    EvaluacionPractica::firstOrCreate(
                        ['id_ap' => $estudianteApId, 'id_modulo' => $i],
                        ['state' => 0, 'estado_evaluacion' => 'Pendiente']
                    );
                }
            }

            if ($asignacion->wasRecentlyCreated) {
                $asignadosCount++;
            }
        }

        return redirect()->back()->with('success', "Se asignaron {$asignadosCount} nuevos estudiantes al grupo correctamente.");
    }

public function destroy($id)
{
    // verificar que el state de evaluacion_practica sea 0, para elinar todo eso
    //$ep = EvaluacionPractica::

    $registro = grupo_estudiante::findOrFail($id);
    $registro->delete();

    return back()->with('success', 'Estudiante eliminado del grupo correctamente.');
}


} 
