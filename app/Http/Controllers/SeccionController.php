<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facultad;
use App\Models\Escuela;
use App\Models\Seccion;
use App\Models\seccion_academica;
use Illuminate\Support\Facades\DB; // <-- 2. Importar DB
use Exception; // <-- 3. Importar Exception


class SeccionController extends Controller
{
    //
    public function index(){
        $semestre = session('semestre_actual_id');

        $facultades = Facultad::all();
        
        // Cargar escuelas y, para cada una, sus secciones del semestre actual.
        $escuelas = Escuela::with([
            'facultad',
            'sa' => function ($query) use ($semestre) {
                $query->where('id_semestre', $semestre)
                    ->orderBy('seccion', 'asc'); // Opcional: ordenar las secciones (A, B, C...)
            }
        ])->orderBy('id', 'desc')->get();
        
        $secciones = []; // Esta variable ya no es necesaria para la tabla principal.


        return view('seccion.index', compact('escuelas', 'facultades', 'secciones'));
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();

            $semestre = session('semestre_actual_id');

            $request->validate([
                'facultad_id' => 'required|exists:facultades,id',
                'escuela_id' => 'required|exists:escuelas,id',
                'seccion' => 'required|string|max:255',
            ]);

            seccion_academica::create([
                'id_semestre' => $semestre,
                'id_escuela' => $request->escuela_id,
                'id_facultad' => $request->facultad_id,
                'seccion' => $request->seccion,
                'state' => true
            ]);

            DB::commit();

            return redirect()->route('seccion.index')->with('success', 'Sección registrada correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al registrar la sección: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $seccion = seccion_academica::findOrFail($id);
            $seccion->delete();

            return redirect()->route('seccion.index')->with('success', 'Sección eliminada correctamente.');
        } catch (Exception $e) {
            return back()->withErrors('Error al eliminar la sección: ' . $e->getMessage());
        }
    }
}
