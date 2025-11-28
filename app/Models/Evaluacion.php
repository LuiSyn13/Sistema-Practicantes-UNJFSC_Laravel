<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'evaluaciones';

    protected $fillable = [
        'id_alumno',
        'anexo_6',
        'anexo_7',
        'anexo_8',
        'pregunta_1',
        'pregunta_2',
        'pregunta_3',
        'pregunta_4',
        'pregunta_5',
        'user_create',
        'user_update',
        'state',
];

    protected $casts = [
        
    ];

    public function ap()
    {
        return $this->belongsTo(asignacion_persona::class, 'id_alumno');
    }
}
