<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practica extends Model
{
    use HasFactory;
    protected $table = 'practicas';

    protected $fillable = [
        'id_ap',
        'estado_practica',
        'tipo_practica',
        'fecha_inicio',
        'fecha_fin',
        'observacion',
        'calificacion',
        'state'
    ];

    public function asignacion_persona()
    {
        return $this->belongsTo(asignacion_persona::class, 'id_ap');
    }

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'id_practica');
    }

    public function jefeInmediato()
    {
        return $this->hasOne(JefeInmediato::class, 'id_practica');
    }
}
