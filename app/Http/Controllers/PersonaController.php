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

class PersonaController extends Controller
{
    public function lista_docentes(){
        $personas = Persona::whereHas('asignacion_persona', function($query){
            $query->where('id_rol', 3);
        })->get();
        $facultades = Facultad::where('estado', 1)->get();
        $escuelas = Escuela::where('estado', 1)->get();
        return view('list_users.docente', compact('personas', 'facultades', 'escuelas'));
    }

    public function lista_supervisores(){
        $personas = Persona::whereHas('asignacion_persona', function($query){
            $query->where('id_rol', 4);
        })->get();
        $facultades = Facultad::where('estado', 1)->get();
        $escuelas = Escuela::where('estado', 1)->get();
        return view('list_users.supervisor', compact('personas', 'facultades', 'escuelas'));
    }

    public function lista_estudiantes(){
        $personas = Persona::whereHas('asignacion_persona', function($query){
            $query->where('id_rol', 5);
        })->get();
        $facultades = Facultad::where('estado', 1)->get();
        $escuelas = Escuela::where('estado', 1)->get();
        return view('list_users.estudiante', compact('personas', 'facultades', 'escuelas'));
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

    public function registro(){
        $user = auth()->user();
        $persona = $user->persona;
        // Si la persona autenticada es rol 2 (docente), excluir también el tipo 'docente titular'
        $rolesQuery = type_users::where('estado', 1)
            ->where('name', '!=', 'admin');

        if ($user->getRolId() == 3) {
            $rolesQuery->where('name', '!=', 'docente titular');
            $rolesQuery->where('name', '!=', 'sub admin');
        }

        $roles = $rolesQuery->get();
    $facultades = Facultad::where('estado', 1)->get();
    $escuelas = Escuela::where('estado', 1)->get();
    $semestres = Semestre::where('estado', 1)->orderBy('ciclo', 'desc')->get();
        
    return view('segmento.registrar', compact('roles', 'facultades', 'escuelas', 'persona', 'semestres'));
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

    public function store(Request $request){
        // Si no se proporciona correo, usar el DNI como correo temporal
        if (empty($request->correo_inst)) {
            $request->correo_inst = $request->codigo . '@unjfsc.edu.pe';
        }

        // Si no se selecciona sexo, usar 'M' como valor por defecto
        if (empty($request->sexo)) {
            $request->sexo = 'M';
        }

        try {
            // Crear el usuario
            $user = User::create([
                'name' => $request->correo_inst,
                'email' => $request->correo_inst,
                'password' => Hash::make($request->codigo), // Usar DNI como contraseña inicial
            ]);

            // Crear la persona
            $persona = new Persona([
                'codigo' => $request->codigo,   
                'dni' => $request->dni,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'celular' => $request->celular,
                'sexo' => $request->sexo,
                'correo_inst' => $request->correo_inst,
                'departamento' => 'Lima Provincia',
                'provincia' => $request->provincia,
                'distrito' => $request->distrito,
                'usuario_id' => $user->id,
                'date_create' => now(),
                'date_update' => now(),
                'estado' => 1
            ]);

            $persona->save();

            $asignar_personar = new asignacion_persona([
                'id_semestre' => $request->semestre,
                'id_persona' => $persona->id,
                'id_rol' => $request->rol,
                'id_escuela' => ($request->rol != 2 || $request->rol != 1) ? $request->escuela:null,
                'id_facultad' => ($request->rol !=1) ? $request->facultad:null,
                'date_create' => now(),
                'date_update' => now(),
                'estado' => 1
            ]);

            $asignar_personar->save();

            return back()->with('success', 'Formulario de Trámite (FUT) subido correctamente.');

        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
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
}
