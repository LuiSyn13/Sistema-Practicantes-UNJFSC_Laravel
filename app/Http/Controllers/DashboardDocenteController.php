<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardDocenteController extends Controller
{
    public function index(Request $request)
    {

        
        $docenteId = Auth::id(); // ID del docente autenticado
    $escuelaId = $request->get('escuela');
    $facultades = DB::table('facultades')->get();

    $semestreCodigo = $request->get('semestre');
    $supervisorId = $request->get('supervisor');
 
    // Escuelas a cargo del docente
    $escuelas = DB::table('grupos_practicas as gp') 
        ->join('escuelas as e', 'gp.id_escuela', '=', 'e.id')
        ->where('gp.id_docente', $docenteId)
        ->select('e.id', 'e.name')
        ->distinct()
        ->get();

    // Base query filtrada por los valores seleccionados
    $baseQuery = DB::table('grupo_estudiante as ge')
        ->join('grupos_practicas as gp', 'ge.id_grupo_practica', '=', 'gp.id')
        ->where('gp.id_docente', $docenteId);

    if ($escuelaId) {
        $baseQuery->where('gp.id_escuela', $escuelaId);
    }

    if ($semestreCodigo) {
        $baseQuery->join('semestres as s', 'gp.id_semestre', '=', 's.id')
                  ->where('s.codigo', $semestreCodigo);
    }

    if ($supervisorId) {
        $baseQuery->where('ge.id_supervisor', $supervisorId);
    }

    $totalEstudiantes = (clone $baseQuery)->distinct('ge.id_estudiante')->count('ge.id_estudiante');
    //$totalGrupos = (clone $baseQuery)->distinct('gp.id')->count('gp.id');
    $totalFichasValidadas = (clone $baseQuery)
        ->join('matriculas as m', 'ge.id_estudiante', '=', 'm.persona_id')
        ->where('m.estado_ficha', 'Completo')
            ->where('m.estado_record', 'Completo')
        ->count();
    $totalSupervisores = (clone $baseQuery)->distinct('ge.id_supervisor')->count('ge.id_supervisor');

    $estudiantesPorEscuela = (clone $baseQuery)
        ->join('escuelas as e', 'gp.id_escuela', '=', 'e.id')
        ->select('e.name as escuela', DB::raw('COUNT(ge.id_estudiante) as total'))
        ->groupBy('e.name')
        ->get();

    $estadoFichas = (clone $baseQuery)
        ->join('matriculas as m', 'ge.id_estudiante', '=', 'm.persona_id')
        ->select('m.estado_ficha', DB::raw('COUNT(*) as total'))
        ->groupBy('m.estado_ficha')
        ->get();

    $groupsData = (clone $baseQuery)
    ->join('semestres as sem', 'gp.id_semestre', '=', 'sem.id') // <-- alias diferente
    ->join('escuelas as e', 'gp.id_escuela', '=', 'e.id')
    ->select(
        'gp.nombre_grupo as name',
        'e.name as school',
        'sem.codigo as semester',
        DB::raw('COUNT(ge.id_estudiante) as students'),
        DB::raw('IF(gp.estado = 1, "Activo", "Inactivo") as status')
    )
    ->groupBy('gp.id', 'gp.nombre_grupo', 'e.name', 'sem.codigo', 'gp.estado')
    ->get();


    $fichasPorMes = (clone $baseQuery)
        ->join('matriculas as m', 'ge.id_estudiante', '=', 'm.persona_id')
        ->select(DB::raw('MONTHNAME(m.created_at) as mes'), DB::raw('COUNT(*) as total'))
        ->whereYear('m.created_at', date('Y'))
        ->groupBy(DB::raw('MONTH(m.created_at)'), DB::raw('MONTHNAME(m.created_at)'))
        ->orderBy(DB::raw('MONTH(m.created_at)'))
        ->get();

    $supervisoresRanking = (clone $baseQuery)
        ->join('personas as p', 'ge.id_supervisor', '=', 'p.id')
        ->select('p.nombres', DB::raw('COUNT(ge.id_estudiante) as total'))
        ->groupBy('p.nombres')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

        $chartData = (clone $baseQuery)
    ->join('escuelas as e', 'gp.id_escuela', '=', 'e.id')
    ->join('semestres as sem', 'gp.id_semestre', '=', 'sem.id')
    ->join('grupo_estudiante as sup', 'ge.id_supervisor', '=', 'sup.id')
    ->join('users as usup', 'sup.id', '=', 'usup.id')
    ->select(
        'gp.nombre_grupo as grupo',
        'usup.name as supervisor',
        DB::raw('COUNT(ge.id_estudiante) as total')
    )
    ->groupBy('gp.nombre_grupo', 'usup.name')
    ->get();

    $listaEstudiantes = (clone $baseQuery)
    ->join('personas as p', 'ge.id_estudiante', '=', 'p.id')
    ->join('escuelas as e', 'gp.id_escuela', '=', 'e.id')
    ->join('facultades as f', 'e.facultad_id', '=', 'f.id')
    ->join('semestres as sem', 'gp.id_semestre', '=', 'sem.id') // alias cambiado
    ->leftJoin('matriculas as m', 'ge.id_estudiante', '=', 'm.persona_id')
    ->select(
        'p.nombres',
        'p.apellidos',
        'e.name as escuela',
        'f.name as facultad',
        'sem.codigo as semestre', // alias actualizado
        DB::raw("COALESCE(m.estado_ficha, 'Sin registrar') as estado_ficha"),
        DB::raw("COALESCE(m.estado_record, 'Sin registrar') as estado_record")
    )
    ->groupBy(
        'p.nombres', 'p.apellidos', 'e.name', 'f.name', 'sem.codigo', 'm.estado_ficha', 'm.estado_record'
    )
    ->get();



    return view('dashboard.dashboardDocente', compact(
        'totalEstudiantes', 'totalFichasValidadas', 'totalSupervisores',
        'estudiantesPorEscuela', 'estadoFichas', 'groupsData', 'fichasPorMes',
        'supervisoresRanking', 'escuelas','chartData','listaEstudiantes', 'facultades'
    ));

    }

public function getSemestres($escuelaId)
{
    $semestres = DB::table('grupos_practicas as gp')
        ->join('semestres as s', 'gp.id_semestre', '=', 's.id')
        ->where('gp.id_escuela', $escuelaId)
        ->select('s.codigo')
        ->distinct()
        ->get();

    return response()->json($semestres); // <<< AÑADIDO
}

public function getSupervisores($escuelaId)
{
    $supervisores = DB::table('grupo_estudiante as ge')
        ->join('grupos_practicas as gp', 'ge.id_grupo_practica', '=', 'gp.id')
        ->join('personas as p', 'ge.id_supervisor', '=', 'p.id')
        ->where('gp.id_escuela', $escuelaId)
        ->select('p.id', 'p.nombres')
        ->distinct()
        ->get();

    return response()->json($supervisores); // <<< AÑADIDO
}

}
