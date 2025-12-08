<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\User;
use App\Models\type_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Facultad;
use App\Models\Escuela;
use App\Models\Semestre;
use App\Models\asignacion_persona;
use Illuminate\Support\Facades\Log;

class PersonaController extends Controller
{
    public function lista_usuarios(Request $request){
        $users = Persona::all();
        return view('list_users.usuarios', compact('users'));        
    }
    
    public function lista_subadmins(Request $request){
        $id_semestre = session('semestre_actual_id');
        $authUser = auth()->user();

        $ap_now = $authUser->persona->asignacion_persona;

        $facultades = Facultad::where('state', 1)->get();

        $escuelas = Escuela::where('state', 1)->get();

        $query = Persona::whereHas('asignacion_persona', function($query) use ($id_semestre, $request, $ap_now){
            $query->where('id_rol', 2);
            $query->where('id_semestre', $id_semestre);

            $query->whereHas('seccion_academica', function($qsa) use ($request, $ap_now){
                if($request->filled('facultad')){
                    $qsa->where('id_facultad', $request->facultad);
                }
                if($request->filled('escuela')){
                    $qsa->where('id_escuela', $request->escuela);
                }
                if($request->filled('seccion')){
                    $qsa->where('id', $request->seccion);
                }
            });
        });

        $personas = $query->with([
            'asignacion_persona.seccion_academica.facultad',
            'asignacion_persona.seccion_academica.escuela',
            'asignacion_persona.seccion_academica'
        ])->get();

        return view('list_users.subadmin', compact('personas', 'facultades', 'escuelas'));
    }

    public function lista_docentes(Request $request){
        $id_semestre = session('semestre_actual_id');
        $authUser = auth()->user();

        $ap_now = $authUser->persona->asignacion_persona;

        $queryFac = Facultad::where('state', 1);
        if ($ap_now->id_rol == 2) {
            $queryFac->where('id', $ap_now->id_facultad);
        }
        $facultades = $queryFac->get();


        $escuelas = Escuela::where('state', 1)->get();

        $query = Persona::whereHas('asignacion_persona', function($query) use ($id_semestre, $request, $ap_now){
            $query->where('id_rol', 3);
            $query->where('id_semestre', $id_semestre);

            $query->whereHas('seccion_academica', function($qsa) use ($request, $ap_now){
                if($request->filled('facultad')){
                    $qsa->where('id_facultad', ($ap_now->id_rol == 2) ? $ap_now->id_facultad : $request->facultad);
                }
                if($request->filled('escuela')){
                    $qsa->where('id_escuela', $request->escuela);
                }
                if($request->filled('seccion')){
                    $qsa->where('id', $request->seccion);
                }
            });
        });

        $personas = $query->with([
            'asignacion_persona.seccion_academica.facultad',
            'asignacion_persona.seccion_academica.escuela',
            'asignacion_persona.seccion_academica'
        ])->get();

        return view('list_users.docente', compact('personas', 'facultades', 'escuelas'));
    }

    public function lista_supervisores(Request $request){
        $id_semestre = session('semestre_actual_id');
        $authUser = auth()->user();

        $ap_now = $authUser->persona->asignacion_persona;

        $queryFac = Facultad::where('state', 1);
        if ($ap_now->id_rol == 2) {
            $queryFac->where('id', $ap_now->id_facultad);
        }
        $facultades = $queryFac->get();

        $escuelas = Escuela::where('state', 1)->get();

        $query = Persona::whereHas('asignacion_persona', function($query) use ($id_semestre, $ap_now, $request){
            $query->where('id_rol', 4);
            $query->where('id_semestre', $id_semestre);
            
            $query->whereHas('seccion_academica', function($qsa) use ($ap_now, $request){
                if($ap_now->id_rol == 3) {
                    $qsa->where('id', $ap_now->id_sa);
                }
                if($request->filled('facultad')){
                    $qsa->where('id_facultad', $request->facultad);
                }
                if($request->filled('escuela')){
                    $qsa->where('id_escuela', $request->escuela);
                }
                if($request->filled('seccion')){
                    $qsa->where('id_seccion', $request->seccion);
                }
            });
        });

        $docentes = $query->with([
            'asignacion_persona.seccion_academica.facultad',
            'asignacion_persona.seccion_academica.escuela',
            'asignacion_persona.seccion_academica'
        ])->get();

        $personas = $docentes;
        
        return view('list_users.supervisor', compact('personas', 'facultades', 'escuelas'));
    }

    public function lista_estudiantes(Request $request){
        $id_semestre = session('semestre_actual_id');
        $authUser = auth()->user();

        $ap_now = $authUser->persona->asignacion_persona;

        $queryFac = Facultad::where('state', 1);
        if ($ap_now->id_rol == 2) {
            $queryFac->where('id', $ap_now->id_facultad);
        }
        $facultades = $queryFac->get();

        Log::info('USUARIO ACTUAL: '.$ap_now);

        $escuelas = Escuela::where('state', 1)->get();

        $query = Persona::whereHas('asignacion_persona', function($query) use ($id_semestre, $request, $ap_now){
            $query->where('id_rol', 5);
            $query->where('id_semestre', $id_semestre);

            $query->whereHas('seccion_academica', function($qsa) use ($ap_now, $request){
                if($ap_now->id_rol == 2) {
                    $qsa->where('id_facultad', $ap_now->id_facultad);
                }
                if($ap_now->id_rol == 3) {
                    $qsa->where('id', $ap_now->id_sa);
                }
                if($request->filled('facultad')){
                    $qsa->where('id_facultad', $request->facultad);
                }
                if($request->filled('escuela')){
                    $qsa->where('id_escuela', $request->escuela);
                }
                if($request->filled('seccion')){
                    $qsa->where('id', $request->seccion);
                }
                //$qsa->where('id', $ap_now->id_sa);
            });
        });

        $docentes = $query->with([
            'asignacion_persona.seccion_academica.facultad',
            'asignacion_persona.seccion_academica.escuela',
            'asignacion_persona.seccion_academica'
        ])->get();

        $personas = $docentes;

        return view('list_users.estudiante', compact('personas', 'facultades', 'escuelas'));
    }

    public function lista_grupos_estudiantes(){
        $id_semestre = session('semestre_actual_id');
        $authUser = auth()->user();

        $ap_now = $authUser->persona->asignacion_persona;

        $grupo = DB::table('grupo_practica')
            ->where('id_supervisor', $ap_now->id)
            ->select('grupo_practica.name', 'grupo_practica.id')
            ->first();

        $grupo_estudiante = DB::table('grupo_estudiante as ge')
            ->join('personas as p', 'ge.id_estudiante', '=', 'p.id')
            ->join('grupo_practica as gp', 'ge.id_grupo_practica', '=', 'gp.id')
            ->where('gp.id_supervisor', $ap_now->id)
            ->select('ge.*', 'p.nombres', 'p.apellidos', 'gp.name as grupo_nombre')
            ->get();

        return view('list_users.grupo_estudiante', compact('grupo', 'grupo_estudiante'));
    }

    public function edit($id){
        $persona = Persona::findOrFail($id);
        return response()->json($persona);
    }

    public function users(){
        // Obtener el usuario logeado
        $user = auth()->user();
        
        // Obtener la persona asociada al usuario
        $persona = $user->persona;
        
        return view('segmento.perfil', compact('persona'));
    }

    public function changePasswordView()
    {
        $user = auth()->user();
        return view('segmento.change-password', compact('user'));
    }

    public function registro(){
        $user = auth()->user();
        $persona = $user->persona;
        $userRolId = $user->getRolId();
        $id_semestre_actual = session('semestre_actual_id');
        $ap = asignacion_persona::where('id_persona', $persona->id)
                                ->where('id_semestre', $id_semestre_actual)
                                ->with([
                                    'seccion_academica.facultad', 
                                    'seccion_academica.escuela', 
                                    'seccion_academica'])
                                ->first();

        $rolesQuery = type_users::where('state', 1)
            ->where('name', '!=', 'admin');
        
        if ($userRolId == 2) { // Sub Admin no puede crear otros Sub Admins
            $rolesQuery->where('name', '!=', 'sub admin');
        }

        if ($userRolId == 3) { // Docente no puede crear Sub Admins ni otros Docentes
            $rolesQuery->where('name', '!=', 'docente titular');
            $rolesQuery->where('name', '!=', 'sub admin');
        }

        $roles = $rolesQuery->get();

        $queryFac = Facultad::where('state', 1);
        if($userRolId == 2 || $userRolId == 3){ // Si es Sub Admin o Docente, filtrar por su facultad
            $queryFac->where('id', $ap->id_facultad);
        }
        $facultades = $queryFac->get();

        $escuelasQuery = Escuela::where('state', 1);
        if($userRolId == 3){ // Si es Docente, filtrar también por su escuela
            $escuelasQuery->where('id', $ap->id_escuela);
        }
        $escuelas = $escuelasQuery->get();

        $semestres = Semestre::where('state', 1)->orderBy('ciclo', 'desc')->get();
            
        return view('segmento.registrar', compact('roles', 'facultades', 'escuelas', 'persona', 'semestres', 'ap'));
    }

    public function getEscuelas($facultad_id){
        $escuelas = Escuela::where('facultad_id', $facultad_id)
            ->where('estado', 1)
            ->get();

        return response()->json($escuelas);
    }

    public function destroy($id){
        $persona = Persona::findOrFail($id);
        $persona->delete();
        
        return redirect()->back()->with('success', 'Persona eliminada correctamente.');
    }

    public function verificar(Request $request) {
        // Validar que los datos necesarios están presentes
        $request->validate([
            'correo_inst' => 'required|email',
            'semestre_id' => 'required|integer|exists:semestres,id',
        ]);

        $correo = $request->input('correo_inst');
        $semestre_id = $request->input('semestre_id');

        $persona = Persona::where('correo_inst', $correo)->first();

        if ($persona) {
            // El usuario existe, ahora verificamos si ya está asignado a este semestre
            $asignacionExistente = asignacion_persona::where('id_persona', $persona->id)
                ->where('id_semestre', $semestre_id)
                ->exists();

            return response()->json([
                'found' => true,
                'already_assigned' => $asignacionExistente,
                'persona' => $persona
            ]);

            Log::info('Persona encontrada:'.$persona);
        }

        return response()->json(['found' => false]);
    }

    public function asignar(Request $request){
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'rol' => 'required|exists:type_users,id',
            'semestre' => 'required|exists:semestres,id',
            'facultad' => 'nullable|exists:facultades,id',
            'escuela' => 'nullable|exists:escuelas,id',
            'seccion' => 'nullable|exists:secciones,id'
        ]);

        // Verificar si ya existe una asignación para evitar duplicados por si acaso
        $asignacionExistente = asignacion_persona::where('id_persona', $request->persona_id)
            ->where('id_semestre', $request->semestre)
            ->first();

        if ($asignacionExistente) {
            return back()->with('error', 'Esta persona ya tiene una asignación en este semestre.');
        }

        try {
            asignacion_persona::create([
                'id_semestre' => $request->semestre,
                'id_persona' => $request->persona_id,
                'id_rol' => $request->rol,
                'id_escuela' => in_array($request->rol, [1, 2]) ? null : $request->escuela,
                'id_facultad' => $request->rol == 1 ? null : $request->facultad,
                'date_create' => now(),
                'date_update' => now(),
                'estado' => 1
            ]);
            return back()->with('success', 'Usuario asignado al semestre actual correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al asignar el usuario: ' . $e->getMessage());
        }
    }

    public function registrarPersona(){
        $request -> validate([
            'codigo' => 'required|string|size:10|unique:personas,codigo',
            'dni' => 'required|string|size:8|unique:personas,dni',
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'celular' => 'nullable|string|size:9',
            'correo_inst' => 'nullable|email|max:150|unique:personas,correo_inst',
            'sexo' => 'nullable|in:M,F',
            'provincia' => 'nullable|string|max:50',
            'distrito' => 'nullable|string|max:50'
        ]);
        try {
            $persona = new Persona([
                'codigo' => $request->codigo,
                'dni' => $request->dni,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'celular' => $request->celular,
                'correo_inst' => $request->correo_inst,
                'sexo' => $request->sexo,
                'provincia' => $request->provincia,
                'distrito' => $request->distrito,
                'date_create' => now(),
                'date_update' => now(),
                'estado' => 1
            ]);
            $persona->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    public function store(Request $request){
        $persona_id = $request->input('persona_id');
        
        $request->validate([
            'rol' => 'required|exists:type_users,id',
            'id_semestre' => 'required|exists:semestres,id',
            'facultad' => 'required|exists:facultades,id',
            //'escuela' => 'required|exists:escuelas,id'
        ]);

        try {
            if (empty($persona_id)) {
                $persona = $this->crearNuevaPersona($request);
                $persona_id_final = $persona->id;
                $success_message = 'Persona creada y asignada al semestre actual correctamente.';
            } else {
                $persona_id_final = $persona_id;
                $success_message = 'Usuario existente asignado al semestre actual correctamente.';
            }

            $this->asignarPersonaASemestre($persona_id_final, $request);

            return back()->with('success', $success_message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Devolver los errores de validación a la vista anterior con los datos de entrada.
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Capturar cualquier otro error y devolverlo a la vista.
            Log::error('Error en PersonaController@store: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error inesperado al registrar. Por favor, intente de nuevo.');
        }
    }

    private function crearNuevaPersona(Request $request)
    {
        $validatedData = $request->validate([
            'dni' => 'nullable|string|size:8|unique:personas,dni',
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'celular' => 'nullable|string|size:9',
            'correo_inst' => 'required|email|max:150|unique:personas,correo_inst',
            'sexo' => 'required|in:M,F',
            'provincia' => 'nullable|string|max:50',
            'distrito' => 'nullable|string|max:50'
        ]);

        $username = explode('@', $validatedData['correo_inst'])[0];
        $isStudent = $request->input('rol') == 5;

        $user = User::create([
            'name' => $username,
            'email' => $validatedData['correo_inst'],
            'password' => Hash::make($isStudent ? $request->codigo : '12345678'),
        ]);

        return Persona::create([
            'codigo' => $username,
            'usuario_id' => $user->id,
            'departamento' => 'Lima Provincias',
            'state' => 1
        ] + $validatedData);
    }

    private function asignarPersonaASemestre($persona_id, Request $request)
    {
        $asignacionExistente = asignacion_persona::where('id_persona', $persona_id)
            ->where('id_semestre', $request->id_semestre)
            ->first();

        if ($asignacionExistente) {
            throw new \Exception('Esta persona ya tiene una asignación en este semestre.');
        }

        $rol = $request->rol;
        $is_admin_or_subadmin = in_array($rol, [1, 2]);
        $is_doc_or_sup = in_array($rol, [3, 4]);

        return asignacion_persona::create([
            'id_semestre' => $request->id_semestre,
            'id_persona' => $persona_id,
            'id_rol' => $rol,
            'id_facultad' => $rol == 2 ? $request->facultad : null,
            'id_sa' => $is_admin_or_subadmin ? null :$request->seccion,
            'state' => $is_doc_or_sup ? 2 : 1 // 2: pendiente, 1: activo
        ]);
    }

    public function store_masivo(Request $request){
        $request->validate([
            'archivo' => 'file|mimes:csv,txt|max:2048',
            'rol' => 'exists:type_users,id',
            'escuela' => 'exists:escuelas,id',
        ]);

        try {
            $archivo = $request->file('archivo');
            $contenido = file($archivo->path());
            
            // Saltar las primeras 3 líneas (headers y datos no necesarios)
            array_shift($contenido); // Línea 1
            array_shift($contenido); // Línea 2
            array_shift($contenido); // Línea 3
            
            // Obtener los headers de la línea 4
            $headers = str_getcsv(array_shift($contenido));
            
            // Mapear los campos del CSV a los campos de la base de datos
            $campoMap = [
                'CodigoUniversitario' => 'codigo',
                'Alumno' => 'nombres',
                'Textbox4' => 'correo_inst'
            ];
            
            $usuariosCreados = 0;
            $errores = [];

            foreach ($contenido as $linea) {
                $datos = str_getcsv($linea);
                
                if (count($datos) !== count($headers)) {
                    $errores[] = "Formato incorrecto en la línea " . ($usuariosCreados + 1);
                    continue;
                }

                // Crear un array con los datos mapeados
                $usuarioData = [];
                foreach ($headers as $index => $header) {
                    if (isset($campoMap[$header])) {
                        if ($header === 'Alumno') {
                            // Separar apellidos y nombres
                            $nombresCompletos = $datos[$index];
                            $partes = explode(' ', $nombresCompletos);
                            
                            // Tomar las dos primeras palabras como apellidos
                            $apellidos = implode(' ', array_slice($partes, 0, 2));
                            // Tomar el resto como nombres
                            $nombres = implode(' ', array_slice($partes, 2));
                            
                            $usuarioData['apellidos'] = $apellidos;
                            $usuarioData['nombres'] = $nombres;
                        } else {
                            $usuarioData[$campoMap[$header]] = $datos[$index];
                        }
                    }
                }

                try {
                    // Crear usuario
                    $user = User::create([
                        'name' => $usuarioData['codigo'],
                        'email' => $usuarioData['correo_inst'],
                        'password' => Hash::make($usuarioData['codigo']),
                    ]);

                    // Crear persona
                    $persona = new Persona([
                        'codigo' => $usuarioData['codigo'],
                        'nombres' => $usuarioData['nombres'],
                        'apellidos' => $usuarioData['apellidos'],
                        'correo_inst' => $usuarioData['correo_inst'],
                        'departamento' => 'Lima Provincias',
                        'usuario_id' => $user->id,
                        'rol_id' => $request->rol, // Usar el ID del rol seleccionado
                        'date_create' => now(),
                        'date_update' => now(),
                        'estado' => 1,
                        'id_escuela' => $request->escuela,
                    ]);

                    $persona->save();
                    $usuariosCreados++;
                } catch (\Exception $e) {
                    $errores[] = "Error al crear usuario en la línea " . ($usuariosCreados + 1) . ": " . $e->getMessage();
                }
            }

            return back()->with('success', 'Formulario de Trámite (FUT) subido correctamente.');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkDni($dni){
        $persona = Persona::where('dni', $dni)->first();
        return response()->json([
            'exists' => !is_null($persona)
        ]);
    }

    public function checkEmail($email){
        $persona = Persona::where('correo_inst', $email)->first();
        return response()->json([
            'exists' => !is_null($persona)
        ]);
    }

    public function update(Request $request){
        $persona = Persona::findOrFail($request->persona_id);

        /*$validated = $request->validate([
            'codigo' => 'nullable|string|size:10',
            'nombres' => 'nullable|string|max:50',
            'apellidos' => 'nullable|string|max:50',
            'dni' => 'nullable|string|size:8|unique:personas,dni,' . $id,
            'celular' => 'nullable|string|size:9',
            'correo_inst' => 'nullable|email|max:150|unique:personas,correo_inst,' . $id,
            'sexo' => 'in:M,F',
            'provincia' => 'nullable|string|max:50',
            'distrito' => 'nullable|string|max:50',
        ]);*/

        try {
            $data = [
                'codigo' => $request->codigo,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'dni' => $request->dni,
                'celular' => $request->celular,
                'sexo' => $request->sexo,
                'correo_inst' => $request->correo_inst,
                'provincia' => $request->provincia,
                'distrito' => $request->distrito,
                'date_update' => now(),
            ];
        
            // Solo actualizar id_escuela si viene en el request
            if ($request->filled('escuela')) {
                $data['id_escuela'] = $request->escuela;
            }
        
            $persona->update($data);

            return back()->with('success', 'Persona actualizada correctamente.');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la persona: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeFoto(Request $request){
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'foto' => 'required|file|mimes:jpg,jpeg,png|max:20480',
        ]);

        $personaId = $request->persona_id;

        // Guardar el archivo
        $nombre = 'foto_' . $personaId . '_' . time() . '.' . $request->file('foto')->getClientOriginalExtension();
        $ruta = $request->file('foto')->storeAs('fotos', $nombre, 'public');

        // Buscar o crear la matrícula
        $persona = Persona::findOrFail($personaId);
        $persona->update([
            'ruta_foto' => 'storage/' . $ruta,
        ]);

        return back()->with('success', 'Foto subida correctamente.');
    }

    // actualizar contraseña
    public function updatePassword(Request $request){
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'new_password.required' => 'La nueva contraseña es obligatoria.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ]);

        $user = auth()->user();

        // Verificar si la contraseña actual es correcta
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'La contraseña actual que ingresaste es incorrecta.');
        }

        // Verificar que la nueva contraseña no sea igual a la actual
        if (Hash::check($request->new_password, $user->password)) {
            return back()->with('error', 'La nueva contraseña no puede ser igual a la actual.');
        }

        // Actualizar la contraseña
        $user->password = Hash::make($request->new_password);
        $user->password_changed_at = now(); // Marcar la contraseña como cambiada
        $user->save();

        return back()->with('success', '¡Tu contraseña ha sido actualizada exitosamente!');
    }
}
