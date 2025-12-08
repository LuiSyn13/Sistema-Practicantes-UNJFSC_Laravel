<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Practica;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $persona = $user->persona;
                $id = $persona->id;
                $ap_id = $persona->asignacion_persona->id;
                $tipo = Practica::where('id_ap', $id)
                                ->value('tipo_practica');
                $view->with([
                    'practica' => $tipo,
                    'nombre' => $persona->nombres,
                    'apellido' => $persona->apellidos,
                    'codigo' => $persona->codigo,
                ]);
            }
        });
    }
}
