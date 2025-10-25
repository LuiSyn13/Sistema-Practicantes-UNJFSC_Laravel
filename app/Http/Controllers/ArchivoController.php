<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use Illuminate\Http\Request;

class ArchivoController extends Controller
{
    public function subirFicha(Request $request)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'ficha' => 'required|file|mimes:pdf|max:20480',
        ]);

        $personaId = $request->persona_id;

        // Guardar el archivo
        $nombre = 'ficha_' . $personaId . '_' . time() . '.pdf';
        $ruta = $request->file('ficha')->storeAs('fichas', $nombre, 'public');

        // Buscar o crear la matrícula
        $matricula = Matricula::firstOrNew(['persona_id' => $personaId]);

        $matricula->ruta_ficha = 'storage/' . $ruta;
        $matricula->estado_ficha = 'en proceso';

        if (!$matricula->exists) {
            $matricula->estado_record = null;
        }

        $matricula->save();

        return back()->with('success', 'Ficha de matrícula subida correctamente.');
    }

    public function subirRecord(Request $request)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'record' => 'required|file|mimes:pdf|max:20480',
        ]);

        $personaId = $request->persona_id;

        $nombre = 'record_' . $personaId . '_' . time() . '.pdf';
        $ruta = $request->file('record')->storeAs('records', $nombre, 'public');

        $matricula = Matricula::firstOrNew(['persona_id' => $personaId]);

        $matricula->ruta_record = 'storage/' . $ruta;
        $matricula->estado_record = 'en proceso';

        if (!$matricula->exists) {
            $matricula->estado_ficha = null;
        }

        $matricula->save();

        return back()->with('success', 'Récord académico subido correctamente.');
    }

    public function showPDF($documento)
    {
        if (!auth()->check()) {
            abort(403, 'No autorizado');
        }

        $path = storage_path('app/public/' . $documento);
        if (!file_exists($path)) {
            abort(404, 'Archivo no encontrado');
        }
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
