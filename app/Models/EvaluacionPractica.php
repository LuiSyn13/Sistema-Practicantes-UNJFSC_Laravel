<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionPractica extends Model
{
    use HasFactory;
    protected $table = 'evaluacion_practica';
    protected $fillable = [
        'id_ap',
        'id_modulo',
        'estado_evaluacion',
        'observacion',
        'f_evaluacion',
        'state'
    ];

    public function asignacion_persona()
    {
        return $this->belongsTo(asignacion_persona::class, 'id_ap');
    }

    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'id_modulo');
    }

    public function evaluacion_archivo() {
        return $this->hasMany(evaluacion_archivo::class, 'id_evaluacion');
    }
}

// Si en un grupo hay 10 estudiantes, los 10 evaluaciones practicas se guardan en esta tabla y debe estar aprobada el estado para pasar al 2do modulo