<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\grupo_estudiante;
use App\Models\grupos_practica;
use App\Models\Matricula;
use App\Models\Persona;
use App\Models\Semestre;
use App\Models\asignacion_persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class validacionMatriculaController extends Controller
{
    public function Vmatricula(){
        $user = auth()->user();
        $persona = $user->persona;
        $asignacion = $persona->asignacion_persona;
        
        if (!$asignacion) {
            return redirect()->back()->with('error', 'No se encontró asignación para este usuario');
        }
        
        $rolId = $asignacion->id_rol;
        $semestreId = $asignacion->id_semestre;
        $escuelaId = $asignacion->id_escuela;

        $semestre_id = session('semestre_actual_id');
        
        // Si es admin (rol 1), mostrar todos los estudiantes, matriculas tiene ap_id de asignacion_persona
        // asignacion_persona -> matricula ap_id
        if ($rolId == 1) {
            /*$estudiantes = asignacion_persona::query() // Usamos query() para empezar un nuevo Query Builder
            ->join('matriculas', 'matriculas.ap_id', '=', 'asignacion_persona.id')
            ->where('asignacion_persona.id_rol', 5) // El rol está en asignacion_persona
            ->select('matriculas.*') // Seleccionamos todas las columnas de matriculas
            // Opcional: También podrías seleccionar algunas columnas de asignacion_persona
            // ->select('matriculas.*', 'asignacion_persona.id as ap_id', ...) 
            ->with([
                'escuela',
                'semestre'
            ])
            ->get();*/

            $estudiantes = Matricula::whereHas('asignacion_persona', function ($query) use ($semestre_id) {
                $query->where('id_semestre', $semestre_id);
                $query->where('id_rol', 5); // Rol de Supervisor
            })->with([
                'asignacion_persona.persona', 
                'asignacion_persona.semestre', 
                'asignacion_persona.seccion_academica.escuela'
            ])->get();
        } 
        // Si es sub admin (rol 2), mostrar estudiantes de su semestre (puede no tener escuela específica)
        else if ($rolId == 2) {
            $query = Matricula::whereHas('asignacion_persona', function ($q) use ($semestreId, $escuelaId) {
                $q->where('id_rol', 5); // Solo estudiantes
                $q->where('id_semestre', $semestreId);
                
                // Si tiene escuela específica, filtrar por ella
                if ($escuelaId) {
                    $q->where('id_escuela', $escuelaId);
                }
            })->with([
                'asignacion_persona.persona',
                'asignacion_persona.semestre',
                'asignacion_persona.seccion_academica.escuela',
                'archivos'
            ]);
            
            $estudiantes = $query->get();
        }
        // Si es docente (rol 3), mostrar estudiantes de su escuela y semestre
        else if ($rolId == 3) {
            $estudiantes = Matricula::whereHas('asignacion_persona', function ($query) use ($asignacion) {
                $query->where('id_rol', 5); // Solo estudiantes
                $query->where('id_sa', $asignacion->id_sa);
            })->with([
                'asignacion_persona.persona',
                'asignacion_persona.semestre',
                'asignacion_persona.seccion_academica.escuela',
                'archivos'
            ])->get();
        }
        // Si es supervisor (rol 4), mostrar estudiantes de su escuela y semestre
        else if ($rolId == 4) {
            $estudiantes = Matricula::whereHas('asignacion_persona', function ($query) use ($asignacion) {
                $query->where('id_rol', 5); // Solo estudiantes
                $query->where('id_sa', $asignacion->id_sa);
            })->with([
                'asignacion_persona.persona',
                'asignacion_persona.semestre',
                'asignacion_persona.seccion_academica.escuela',
                'archivos'
            ])->get();
        }
        else {
            $estudiantes = collect(); // Lista vacía para otros roles
        }


        return view('ValidacionMatricula.ValidacionMatricula', compact('estudiantes'));
    }
    
    public function actualizarEstadoFicha(Request $request, $id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->estado_ficha = $request->estado_ficha;
        $matricula->save();

        return back()->with('success', 'Estado de ficha actualizado correctamente');
    }

    public function actualizarEstadoRecord(Request $request, $id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->estado_record = $request->estado_record;
        $matricula->save();

        return back()->with('success', 'Estado de récord académico actualizado correctamente');
    }


}
