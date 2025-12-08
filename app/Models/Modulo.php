<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;
    protected $table = 'modulos';
    protected $fillable = [
        'name',
        'descripcion',
        'state'
    ];

    public function evaluacion_practica()
    {
        return $this->hasMany(EvaluacionPractica::class, 'id_modulo');
    }
}
