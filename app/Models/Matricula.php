<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matricula extends Model
{
    use HasFactory;
    protected $table = 'matriculas';
    protected $fillable = [
        'id_ap',
        'estado_matricula',
        'observacion',
        'f_matricula',
        'state'
    ];

    public function asignacion_persona()
    {
        return $this->belongsTo(asignacion_persona::class, 'id_ap');
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivo');
    }

}
