<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Acreditar;
use App\Models\EvaluacionPractica;
use App\Models\evaluacion_archivo;
use App\Models\Archivo;
use App\Models\Practica;
use App\Models\grupo_estudiante;
use App\Models\grupo_practica;
use Illuminate\Http\Request;
// Log
use Illuminate\Support\Facades\Log;

class ArchivoController extends Controller
{
    public function subirFicha(Request $request)
    {   
        $request->validate([
            'ap_id' => 'required|exists:asignacion_persona,id',
            'ficha' => 'required|file|mimes:pdf|max:20480',
        ]);

        $id_ap = $request->ap_id;

        $matricula = Matricula::firstOrCreate(
            ['id_ap' => $id_ap],
            [
                'estado_matricula' => 'Pendiente',
                'state' => 1
            ]
        );

        $file = $request->file('ficha');
        $nombre = 'ficha_' . $id_ap . '_' . time() . '.pdf';
        $ruta = $file->storeAs('fichas', $nombre, 'public');
        $rutaCompleta = 'storage/' . $ruta;

        Archivo::create([
            'archivo_id' => $matricula->id,
            'archivo_type' => Matricula::class,
            'estado_archivo' => 'Enviado',
            'tipo' => 'ficha',
            'ruta' => $rutaCompleta,
            'comentario' => null,
            'subido_por_user_id' => $id_ap,
            'state' => 1
        ]);

        $matricula->ruta_ficha = $rutaCompleta;

        return back()->with('success', 'Ficha subida correctamente.');
    }

    public function subirRecord(Request $request)
    {
        $request->validate([
            'ap_id' => 'required|exists:asignacion_persona,id',
            'record' => 'required|file|mimes:pdf|max:20480',
        ]);

        $id_ap = $request->ap_id;

        $matricula = Matricula::firstOrCreate(
            ['id_ap' => $id_ap],
            [
                'estado_matricula' => 'Pendiente',
                'state' => 1
            ]
        );

        $file = $request->file('record');
        $nombre = 'record_' . $id_ap . '_' . time() . '.pdf';
        $ruta = $file->storeAs('records', $nombre, 'public');
        $rutaCompleta = 'storage/' . $ruta;

        Archivo::create([
            'archivo_id' => $matricula->id,
            'archivo_type' => Matricula::class,
            'estado_archivo' => 'Enviado',
            'tipo' => 'record',
            'ruta' => $rutaCompleta,
            'comentario' => null,
            'subido_por_user_id' => $id_ap,
            'state' => 1
        ]);

        $matricula->save();

        return back()->with('success', 'Record subida correctamente.');
    }

    public function subirCLectiva(Request $request)
    {
        $request->validate([
            'ap_id' => 'required|exists:asignacion_persona,id',
            'carga_lectiva' => 'required|file|mimes:pdf|max:20480',
        ]);

        $id_ap = $request->ap_id;

        $acreditacion = Acreditar::firstOrCreate(
            ['id_ap' => $id_ap],
            [
                'estado_acreditacion' => 'Pendiente',
                'state' => 1
            ]
        );

        $file = $request->file('carga_lectiva');
        $nombre = 'cl_' . $id_ap . '_' . time() . '.pdf';
        $ruta = $file->storeAs('cargas_lectivas', $nombre, 'public');
        $rutaCompleta = 'storage/' . $ruta;

        Archivo::create([
            'archivo_id' => $acreditacion->id,
            'archivo_type' => Acreditar::class,
            'estado_archivo' => 'Enviado',
            'tipo' => 'carga_lectiva',
            'ruta' => $rutaCompleta,
            'comentario' => null,
            'subido_por_user_id' => $id_ap,
            'state' => 1
        ]);

        $acreditacion->save;

        return back()->with('success', 'Constancia de carga lectiva subida correctamente.');
    }

    public function subirHorario(Request $request)
    {
        $request->validate([
            'ap_id' => 'required|exists:asignacion_persona,id',
            'horario' => 'required|file|mimes:pdf|max:20480',
        ]);
        
        $id_ap = $request->ap_id;

        $acreditacion = Acreditar::firstOrCreate(
            ['id_ap' => $id_ap],
            [
                'estado_acreditacion' => 'Pendiente',
                'state' => 1
            ]
        );

        $file = $request->file('horario');
        $nombre = 'horario_' . $id_ap . '_' . time() . '.pdf';
        $ruta = $file->storeAs('horarios', $nombre, 'public');
        $rutaCompleta = 'storage/' . $ruta;

        Archivo::create([
            'archivo_id' => $acreditacion->id,
            'archivo_type' => Acreditar::class,
            'estado_archivo' => 'Enviado',
            'tipo' => 'horario',
            'ruta' => $rutaCompleta,
            'comentario' => null,
            'subido_por_user_id' => $id_ap,
            'state' => 1
        ]);

        $acreditacion->save;
        return back()->with('success', 'Horario subida correctamente.');
    }

    public function subirResolucion(Request $request)
    {
        $request->validate([
            'ap_id' => 'required|exists:asignacion_persona,id',
            'resolucion' => 'required|file|mimes:pdf|max:20480',
        ]);

        $id_ap = $request->ap_id;

        $acreditacion = Acreditar::firstOrCreate(
            ['id_ap' => $id_ap],
            [
                'estado_acreditacion' => 'Pendiente',
                'estado' => 1
            ]
        );

        $file = $request->file('resolucion');
        $nombre = 'resolucion_' . $id_ap . '_' . time() . '.pdf';
        $ruta = $file->storeAs('resoluciones', $nombre, 'public');
        $rutaCompleta = 'storage/' . $ruta;

        Archivo::create([
            'archivo_id' => $acreditacion->id,
            'archivo_type' => Acreditar::class,
            'estado_archivo' => 'Enviado',
            'tipo' => 'resolucion',
            'ruta' => $rutaCompleta,
            'comentario' => null,
            'subido_por_user_id' => $id_ap,
            'state' => 1
        ]);

        $acreditacion->save;
        return back()->with('success', 'Resolución subida correctamente.');
    }

    public function subirAnexo(Request $request)
    {
        // Lógica para subir anexos N
        $request->validate([
            'ap_id' => 'required|exists:asignacion_persona,id',
            'nota' => 'required|numeric|min:0|max:20',
            'number' => 'required|integer|min:1',
            // anexo es required solo si no existe rutaAnexo
            'rutaAnexo' => 'nullable|string',
            'anexo' => 'nullable|file|mimes:pdf|max:20480',
            'modulo' => 'required|integer|min:1',
            //'anexo' => 'required|file|mimes:pdf|max:20480',
        ]);

        Log::info('Subiendo anexo para AP ID: ' . $request->ap_id . ' Tipo: ' . $request->number);
        Log::info('Ruta Anexo: ' . $request->rutaAnexo);
        Log::info('Modulo: ' . $request->modulo);
        $id_ap = $request->ap_id;
        $number = $request->number;

        // buscar la evaluacion Practica
        $evaluacionPractica = EvaluacionPractica::where('id_ap', $id_ap)->where('id_modulo', $request->modulo)->first();
        if (!$evaluacionPractica) {
            return back()->with('error', 'No se encontró la evaluación práctica para el AP ID: ' . $id_ap . ' y el módulo: ' . $request->modulo);
        }

        Log::info('evaluacionPractica: ' . json_encode($evaluacionPractica));

        /*$evaluacionPractica = EvaluacionPractica::firstOrCreate(
            ['id_ap' => $id_ap],
            [
                'id_modulo' => $request->modulo,
                'estado_evaluacion' => 'Pendiente',
                'state' => 1
            ]
        );*/

        $evaluacion_archivo = evaluacion_archivo::create([
            'id_evaluacion' => $evaluacionPractica->id,
            'nota' => $request->nota,
            'observacion' => null,
            'state' => 1
        ]);

        if(!$request->hasFile('anexo') && !$request->rutaAnexo) {
            return back()->with('error', 'Debe proporcionar un archivo de anexo o una ruta existente.');
        }

        if($request->hasFile('anexo')) {
            $file = $request->file('anexo');
            $nombre = 'anexo_' . $number . '_' . $id_ap . '_' . time() . '.pdf';
            $ruta = $file->storeAs('anexos', $nombre, 'public');
            $rutaCompleta = 'storage/' . $ruta;
        } else {
            $rutaCompleta = $request->rutaAnexo;
        }

        Archivo::create([
            'archivo_id' => $evaluacion_archivo->id,
            'archivo_type' => evaluacion_archivo::class,
            'estado_archivo' => 'Enviado',
            'tipo' => 'anexo_' . $number,
            'ruta' => $rutaCompleta,
            'comentario' => null,
            'subido_por_user_id' => $id_ap,
            'state' => 1
        ]);

        return back()->with('success', 'Anexo subido correctamente.');
    }

    public function actualizarEstadoAnexo(Request $request)
    {
        //
        $validated = $request->validate([
            // ... campos anteriores ...
            'estado' => 'required|in:Enviado,Aprobado,Corregir',
            'evaluacion' => 'required|exists:evaluacion_archivo,id',
            'archivo' => 'required|exists:archivos,id',
            'correccionTipo' => 'nullable|in:2,3,4', // Los valores son 2, 3, 4 según tu HTML
            'comentario' => 'nullable|string',
        ]);

        $estado = $request->estado;
        // obtener evaluacion_archivo donde tipo de archivos sea $request->anexo
        if($estado == 'Enviado') {
            return back()->with('error', 'El estado "Enviado" no es válido para la actualización.');
        }

        $evaluacion_archivo = evaluacion_archivo::findOrFail($request->evaluacion);
        $evaluacion_archivo->state = ($estado == 'Aprobado') ? 5 : $request->correccionTipo;
        $evaluacion_archivo->observacion = $request->comentario;
        $evaluacion_archivo->save();

        $archivo = Archivo::findOrFail($request->archivo);
        $archivo->estado_archivo = $request->estado;
        $archivo->save();

        if($estado == 'Aprobado') {
            $ep = EvaluacionPractica::findOrFail($evaluacion_archivo->id_evaluacion);
            // Aumentar contador de archivos aprobados para esta evaluación (asumimos 2 anexos: 7 y 8)
            $ep->state = intval($ep->state) + 1;

            if($ep->state >= 2) {
                // marcar evaluación práctica como aprobada
                $ep->estado_evaluacion = 'Aprobado';
                $ep->f_evaluacion = now();
                $ep->save();

                // Ahora comprobar si todo el grupo ya aprobó este mismo módulo
                try {
                    // Buscar el grupo al que pertenece este asignacion_persona
                    $ge = grupo_estudiante::where('id_estudiante', $ep->id_ap)->first();
                    if ($ge) {
                        $group = grupo_practica::find($ge->id_grupo_practica);
                        if ($group) {
                            $currentGroupModule = intval($group->id_modulo ?? 0);

                            // Solo considerar progreso si la evaluación pertenece al módulo actual del grupo
                            if ($ep->id_modulo == $currentGroupModule) {
                                // total estudiantes asignados actualmente al grupo
                                $totalStudents = grupo_estudiante::where('id_grupo_practica', $group->id)->count();

                                // contar evaluaciones aprobadas para este módulo entre los estudiantes del grupo
                                $approvedCount = EvaluacionPractica::where('id_modulo', $currentGroupModule)
                                    ->where('estado_evaluacion', 'Aprobado')
                                    ->whereHas('asignacion_persona.grupo_estudiante', function ($q) use ($group) {
                                        $q->where('id_grupo_practica', $group->id);
                                    })
                                    ->count();

                                // Si todos los estudiantes actuales del grupo tienen la evaluación aprobada, avanzar módulo
                                if ($totalStudents > 0 && $approvedCount >= $totalStudents) {
                                    // Avanzar módulo en 1, sin pasar de 4
                                    $group->id_modulo = min(4, ($group->id_modulo ?? 0) + 1);
                                    $group->save();
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error comprobando progreso de grupo después de aprobar evaluación práctica: ' . $e->getMessage());
                }
            } else {
                // aún no tiene ambos anexos aprobados, solo guardar el contador
                $ep->save();
            }
        }

        return back()->with('success', 'Anexo actualizado correctamente.');
        
    }

    public function getDocumentoPractica($practica, $type) {
        Log::info('Buscando documentos de práctica', ['practica' => $practica, 'type' => $type]);

        // Buscamos en la tabla archivos los registros asociados a la práctica
        // que coincidan con el tipo solicitado. Se asume que para archivos de
        // práctica `archivo_type` contiene la clase Practica::class y
        // `archivo_id` es el id de la práctica.
        try {
            $archivos = Archivo::where('archivo_type', Practica::class)
                ->where('archivo_id', $practica)
                ->where('tipo', $type)
                ->select('id', 'estado_archivo', 'ruta')
                ->first();

            return response()->json($archivos);
        } catch (\Exception $e) {
            Log::error('Error obteniendo documentos de práctica: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno al obtener documentos'], 500);
        }
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
