<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreFacultadRequest;
use App\Http\Requests\UpdateFacultadRequest;
use App\Models\Facultad;
use Illuminate\Support\Facades\DB;
use Exception;

class FacultadController extends Controller
{
    public function index(Request $request)
    {
        $query = Facultad::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Obtenemos TODOS
        $facultades = $query->orderBy('id', 'desc')->get();

        return view('facultad.index', compact('facultades'));
    }

    public function store(StoreFacultadRequest $request)
    {
        try {
            DB::beginTransaction();

            Facultad::create([
                'name' => $request->name,
                'user_create' => null,
                'date_create' => now(),
                'estado' => true
            ]);

            DB::commit();

            return redirect()->route('facultad.index')
                             ->with('success', 'Facultad registrada correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al guardar la facultad: ' . $e->getMessage());
        }
    }

    public function update(UpdateFacultadRequest $request, Facultad $facultad)
    {
        try {
            $facultad->update([
                'name' => $request->name,
                'date_update' => now(),
            ]);

            return redirect()->route('facultad.index')
                             ->with('success', 'Facultad actualizada correctamente.');
        } catch (Exception $e) {
            return back()->withErrors('Error al actualizar la facultad: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $facultad = Facultad::findOrFail($id);
            $facultad->delete();

            return redirect()->route('facultad.index')
                             ->with('success', 'Facultad eliminada correctamente.');
        } catch (Exception $e) {
            return back()->withErrors('Error al eliminar la facultad: ' . $e->getMessage());
        }
    }
}
