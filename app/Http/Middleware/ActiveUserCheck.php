<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- ¡Añade esta línea!
use App\Models\Persona;               // <--- ¡Añade esta línea!
use App\Models\asignacion_persona;
use Illuminate\Support\Facades\Log;

class ActiveUserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        if (is_null($user->password_changed_at) && !$request->routeIs('persona.change.password.view')) {
            session()->flash('info', 'Por su seguridad, es necesario que actualice su contraseña antes de continuar.');
            return redirect()->route('persona.change.password.view');
        }

        $id_persona = Persona::where(['usuario_id' => $user->id])->first();

        $semestre = session('semestre_actual_id');

        $ap_user = asignacion_persona::where(['id_persona' => $id_persona->id])
            ->where(['id_semestre' => $semestre])
            ->first();

        if ($ap_user && $ap_user->state == 2 && $ap_user->id_rol == 3) {
            return redirect('/acreditarDTitular');
        } else if ($ap_user && $ap_user->state == 2 && $ap_user->id_rol == 4) {
            return redirect('/acreditarDSupervisor');
        }

        return $next($request);
    }
}
