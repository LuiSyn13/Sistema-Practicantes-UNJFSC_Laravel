<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Semestre;
use App\Models\Facultad;
use App\Models\Escuela;
use App\Models\Acreditar;
use App\Models\Archivo;
use App\Models\Matricula;
use App\Models\asignacion_persona;
use Illuminate\Support\Facades\Log;


class AcreditarController extends Controller
{
    //
    // funcion que retorne las facultades

    public function ADTitular(Request $request)
    {
        $id_semestre = session('semestre_actual_id');
        $authUser = auth()->user();

        $ap_now = $authUser->persona->asignacion_persona;

        $queryFac = Facultad::where('state', 1);
        if ($ap_now->id_rol == 2) {
            $queryFac->where('id', $ap_now->id_facultad);
        }
        $facultades = $queryFac->get();

        // debe reunir los datos de la tabla
        $acreditar = Acreditar::whereHas('asignacion_persona', function ($query) use ($id_semestre) {
            $query->where('id_semestre', $id_semestre);
            $query->where('id_rol', 3); // Rol de Supervisor
        })->with([
            'asignacion_persona.persona', 
            'asignacion_persona.semestre', 
            'asignacion_persona.seccion_academica.escuela'
        ])->get();

        $option = 1;

        if (!$acreditar) {
            $acreditar = new Acreditar(['id_ap' => $ap->id, 'estado_acreditacion' => 'Pendiente']);
        }

        $msj = 'Docente';

        return view('ValidacionAcreditacion.ValidacionDocente', compact('msj', 'facultades','acreditar', 'option'));
    }

    public function ADSupervisor() {
        $id_semestre = session('semestre_actual_id');
        $authUser = auth()->user();

        $ap_now = $authUser->persona->asignacion_persona;

        $queryFac = Facultad::where('state', 1);
        if ($ap_now->id_rol == 2) {
            $queryFac->where('id', $ap_now->id_facultad);
        }
        $facultades = $queryFac->get();
    
        // Obtener las acreditaciones de los supervisores para el semestre actual
        $acreditar = Acreditar::whereHas('asignacion_persona', function ($query) use ($id_semestre) {
            $query->where('id_semestre', $id_semestre);
            $query->where('id_rol', 4); // Rol de Supervisor
        })->with([
            'asignacion_persona.persona', 
            'asignacion_persona.semestre', 
            'asignacion_persona.seccion_academica.escuela'
        ])->get();

        $option = 2;

        if (!$acreditar) {
            $acreditar = new Acreditar(['id_ap' => $ap->id, 'estado_acreditacion' => 'Pendiente']);
        }

        $msj = 'Dupervisor';
    
        return view('ValidacionAcreditacion.ValidacionDocente', compact('msj', 'facultades', 'acreditar', 'option'));
    }

    public function acreditarDTitular()
    {
        // Tengo que enviar el id de la persona en la vista
        $persona_id = auth()->user()->persona->id;
        $semestre_id = session('semestre_actual_id');

        $ap = asignacion_persona::where('id_persona', $persona_id)
            ->where('id_semestre', $semestre_id)
            ->first();

        $acreditacion = Acreditar::where('id_ap', $ap->id)
            ->with(['archivos' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->first();
        
        if(!$acreditacion) {
            $acreditacion = new Acreditar(['id_ap' => $ap->id, 'estado_acreditacion' => 'Pendiente']);
        }

        return view('acreditacion.acreditacionDocente', compact('ap', 'acreditacion'));
    }

    public function acreditarDSupervisor()
    {
        // Tengo que enviar el id de la persona en la vista
        $persona_id = auth()->user()->persona->id;
        $semestre_id = session('semestre_actual_id');
        $ap = asignacion_persona::where('id_persona', $persona_id)
            ->where('id_semestre', $semestre_id)
            ->first();
            
        $acreditacion = Acreditar::where('id_ap', $ap->id)
            ->with(['archivos' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->first();
        
        if(!$acreditacion) {
            $acreditacion = new Acreditar(['id_ap' => $ap->id, 'estado_acreditacion' => 'Pendiente']);
        }

        return view('acreditacion.acreditacionDocente', compact('ap', 'acreditacion'));
    }

    public function actualizarEstadoArchivo(Request $request, $id_archivo) {
        $rol = auth()->user()->getRolId();

        $archivo = Archivo::findOrFail($id_archivo);
        $archivo->estado_archivo = $request->estado;
        $archivo->comentario = $request->comentario;
        $archivo->revisado_por_user_id = $rol;
        $archivo->save();
        
        $id_file = $archivo->archivo_id;

        $ap = asignacion_persona::findOrFail($request->ap_id);

        if($ap->id_rol == 3 || $ap->id_rol == 4) {
            $this->verificarEstadoAcreditacion($archivo->archivo_id, $ap->id_rol);
        } else if($ap->id_rol == 5) {
            $this->verificarEstadoMatricula($archivo->archivo_id);
        }

        return back()->with('success', 'Estado del archivo actualizado correctamente');
    }

    public function verificarEstadoMatricula($id_file) {
        $matricula = Matricula::findOrFail($id_file);
        $doc_requeridos = ['ficha', 'record'];
        $todos_los_archivos = Archivo::where('archivo_id', $id_file)
        ->where('archivo_type', Matricula::class) // Asegurar la relación polimórfica
        ->orderBy('created_at', 'desc')
        ->get();

        $archivos_por_tipo = $todos_los_archivos->groupBy('tipo')
        ->map(function ($group) {
            return $group->first(); // El 'first()' es el más reciente debido al orderBy('desc') anterior
        });

        $archivo_aprob = true;

        foreach ($doc_requeridos as $tipo_requerido) {
            $latest_file = $archivos_por_tipo->get($tipo_requerido); 
            
            if (is_null($latest_file)) {
                $archivo_aprob = false;
                break;
            }

            if ($latest_file->estado_archivo != 'Aprobado') {
                $archivo_aprob = false;
                break;
            }
        }

        if($archivo_aprob && $matricula->estado_archivo != 'Completo') {
            $matricula->estado_matricula = 'Completo';
            $matricula->save();
        }
    }

    public function verificarEstadoAcreditacion($id_acreditacion, $rol) {
        $acreditacion = Acreditar::findOrFail($id_acreditacion);
        $doc_requeridos = [];
        if($rol == 3) {
            $doc_requeridos = ['carga_lectiva', 'horario'];
        } else if($rol == 4) {
            $doc_requeridos = ['carga_lectiva', 'horario', 'resolucion'];
        }

        $todos_los_archivos = Archivo::where('archivo_id', $id_acreditacion)
        ->where('archivo_type', Acreditar::class) // Asegurar la relación polimórfica
        ->orderBy('created_at', 'desc') // Los más nuevos primero
        ->get(); // <-- CLAVE: Ejecuta la consulta y trae la Colección

        $archivos_por_tipo = $todos_los_archivos->groupBy('tipo')
        ->map(function ($group) {
            return $group->first(); // El 'first()' es el más reciente debido al orderBy('desc') anterior
        });

        $archivos_vig = $todos_los_archivos->unique('tipo');
        $archivo_aprob = true;

        foreach ($doc_requeridos as $tipo_requerido) {
            $latest_file = $archivos_por_tipo->get($tipo_requerido); 
            
            if (is_null($latest_file)) {
                $archivo_aprob = false;
                break;
            }

            if ($latest_file->estado_archivo != 'Aprobado') {
                $archivo_aprob = false;
                break;
            }
        }

        if($archivo_aprob && $acreditacion->estado_acreditacion != 'Aprobado') {
            $acreditacion->estado_acreditacion = 'Aprobado';
            $acreditacion->f_acreditacion = now();
            $acreditacion->save();
            $this->actualizarEstadoAsignacionPersona($acreditacion->id_ap);
        } else if(!$archivo_aprob && $acreditacion->estado_acreditacion != 'Pendiente') {
            $acreditacion->estado_acreditacion = 'Pendiente';
            $acreditacion->save();
        }
    }

    public function actualizarEstadoAsignacionPersona($id_ap) {
        $ap = asignacion_persona::findOrFail($id_ap);
        $ap->state = 1;
        $ap->save();
    }
}
