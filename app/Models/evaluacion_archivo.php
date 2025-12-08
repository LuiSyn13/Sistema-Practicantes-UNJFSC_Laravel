<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evaluacion_archivo extends Model
{
    use HasFactory;
    protected $table = 'evaluacion_archivo';
    protected $fillable = [
        'id_evaluacion',
        'nota',
        'observacion',
        'state'
    ];

    public function evaluacion_practica()
    {
        return $this->belongsTo(EvaluacionPractica::class, 'id_evaluacion');
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivo');
    }
}
