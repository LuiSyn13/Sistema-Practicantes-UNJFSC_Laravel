<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\Facultad;
use App\Models\grupo_estudiante;
use App\Models\grupos_practica;
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
            $grupos_practica = grupos_practica::all();
        }else{
            $grupos_practica = grupos_practica::where('id_docente',$id )->get();
        }
        //$docentes = Persona::where('rol_id', 3)->get(); // Ajusta rol_id si es necesario
        $docentes = Persona::whereHas('asignacion_persona', function ($query) {
            $query->where('id_rol', 3);
        })->get();
        $supervisoresAsignados = DB::table('grupo_estudiante')
            ->select('id_supervisor')
            ->distinct()
            ->pluck('id_supervisor');

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
    
    foreach ($request->estudiantes as $id_estudiante) {
        grupo_estudiante::create([
            'id_supervisor' => $request->id_supervisor,
            'id_grupo_practica' => $request->grupo_id,
            'id_estudiante' => $id_estudiante,
            'estado' => 1, 
        ]);
    }

    return redirect()->back()->with('success', 'Alumno(s) asignado(s) correctamente.');
}
public function destroy($id)
{
    $registro = grupo_estudiante::findOrFail($id);
    $registro->delete();

    return back()->with('success', 'Estudiante eliminado del grupo correctamente.');
}


} 
