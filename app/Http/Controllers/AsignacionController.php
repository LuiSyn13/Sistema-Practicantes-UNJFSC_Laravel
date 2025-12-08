<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\Facultad;
use App\Models\grupo_practica;
use App\Models\grupo_estudiante;
use App\Models\Persona;
use App\Models\asignacion_persona;
use App\Models\Semestre;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Log;

class AsignacionController extends Controller
{
    //as 
    public function index(){
        $user = auth()->user();
        $persona = $user->persona;
        $userRolId = $user->getRolId();
        $id_semestre_actual = session('semestre_actual_id');
        $ap = asignacion_persona::where('id_persona', $persona->id)
                                ->where('id_semestre', $id_semestre_actual)
                                ->with([
                                    'seccion_academica.facultad', 
                                    'seccion_academica.escuela', 
                                    'seccion_academica'
                                    ])
                                ->first();

        $facQuery = Facultad::query();
        if ($userRolId == 2) {
            $facQuery->where('id', $ap->id_facultad);
        }
        $facultades = $facQuery->get();

        $docentes = Persona::whereHas('asignacion_persona', function($query){
            $query->where('id_rol', 3);
        })->get(); // Ajusta rol_id si es necesario
        $semestres = Semestre::all();
        $escuelas = Escuela::all();
        //$grupos_practica = grupo_practica::all();
        $grupos_practica = grupo_practica::with([
            'seccion_academica.facultad',
            'seccion_academica.escuela',
            'seccion_academica.semestre',
            'docente.persona',
            'supervisor.persona'
        ])
        ->where('id_sa', $ap->id_sa)
        ->get();

        if($grupos_practica == null) {
            $grupos_practica = new grupo_practica(['id_docente' => $persona->id]);
        }

        return view('asignatura.asignatura', compact('ap', 'docentes', 'semestres', 'escuelas', 'facultades', 'grupos_practica'));
    } 

    public function store(Request $request)
    {
        $request->validate([
            'dtitular' => 'required|exists:asignacion_persona,id',
            'dsupervisor' => 'required|exists:asignacion_persona,id',
            'seccion' => 'required|exists:seccion_academica,id',
            'nombre_grupo' => 'required|string|max:50'
        ]);

        $existe = grupo_practica::where('id_docente', $request->dtitular)
            ->where('id_supervisor', $request->dsupervisor)
            ->where('id_sa', $request->seccion)
            ->exists();

        if ($existe) {
            return redirect()->back()->with('error', 'Ya existe un grupo con el mismo semestre y escuela.');
        }

        // Crear el grupo si no existe
        grupo_practica::create([
            'name' => $request->nombre_grupo,
            'id_docente' => $request->dtitular,
            'id_supervisor' => $request->dsupervisor,
            'id_sa' => $request->seccion,
            'state' => true,
        ]);

        return redirect()->back()->with('success', 'Grupo de práctica registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        // Validar solo los campos que se permiten editar.
        $request->validate([
            'nombre_grupo' => 'required|string|max:50',
            'dsupervisor' => 'required|exists:asignacion_persona,id',
        ]);

        // Actualizar solo el nombre y el supervisor.
        grupo_practica::where('id', $id)->update([
            'name' => $request->nombre_grupo,
            'id_supervisor' => $request->dsupervisor
        ]);

        return redirect()->back()->with('success', 'Grupo actualizado correctamente.');
    }

    public function eliminar($id)
    { 
        try {
            grupo_practica::destroy($id);
        return redirect()->back()->with('success', 'Grupo eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo eliminar el grupo. Puede que tenga estudiantes asignados.');
        }
        
    }
}
