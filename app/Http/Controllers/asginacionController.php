<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\Facultad;
use App\Models\grupos_practica;
use App\Models\Persona;
use App\Models\Semestre;
use Illuminate\Http\Request; 

class asginacionController extends Controller
{
    //as 
    public function index(){
        $docentes = Persona::whereHas('asignacion_persona', function($query){
            $query->where('id_rol', 3);
        })->get(); // Ajusta rol_id si es necesario
        $semestres = Semestre::all();
        $escuelas = Escuela::all();
        $facultades = Facultad::all();
        $grupos_practica = grupos_practica::all(); 

        return view('asignatura.asignatura', compact('docentes', 'semestres', 'escuelas', 'facultades', 'grupos_practica'));
    } 

    public function store(Request $request)
    {
        $request->validate([
            'id_docente' => 'required|exists:personas,id',
            'id_semestre' => 'required|exists:semestres,id',
            'id_escuela' => 'required|exists:escuelas,id',
            'nombre_grupo' => 'required|string|max:50',
        ]);

        $existe = grupos_practica::where('id_semestre', $request->id_semestre)
            ->where('id_escuela', $request->id_escuela)
            ->exists();

        if ($existe) {
            return redirect()->back()->with('error', 'Ya existe un grupo con el mismo semestre y escuela.');
        }

        // Crear el grupo si no existe
        grupos_practica::create([
            'id_docente' => $request->id_docente,
            'id_semestre' => $request->id_semestre,
            'id_escuela' => $request->id_escuela,
            'nombre_grupo' => $request->nombre_grupo,
            'date_create' => now(),
            'estado' => true,
        ]);

        return redirect()->back()->with('success', 'Grupo de práctica registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_docente' => 'required|exists:personas,id',
            'id_semestre' => 'required|exists:semestres,id',
            'id_escuela' => 'required|exists:escuelas,id',
            'nombre_grupo' => 'required|string|max:50',
        ]);

        grupos_practica::where('id', $id)->update([
            'id_docente' => $request->id_docente,
            'id_semestre' => $request->id_semestre,
            'id_escuela' => $request->id_escuela,
            'nombre_grupo' => $request->nombre_grupo,
            'date_update' => now(),
        ]);

        return redirect()->back()->with('success', 'Grupo actualizado correctamente.');
    }

    public function eliminar($id)
    { 
        grupos_practica::destroy($id);
        return redirect()->back()->with('success', 'Grupo eliminado correctamente.');
    }
}
