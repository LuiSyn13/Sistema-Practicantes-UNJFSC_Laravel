<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acreditar extends Model
{
    use HasFactory;
    protected $table = 'acreditaciones';
    protected $fillable = [
        'id_ap',
        'estado_acreditacion',
        'observacion',
        'f_acreditacion',
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
