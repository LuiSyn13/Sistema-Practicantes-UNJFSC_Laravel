<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class seccion_academica extends Model
{
    use HasFactory;
    protected $table = 'seccion_academica';

    protected $fillable = [
        'id_semestre',
        'id_facultad',
        'id_escuela',
        'seccion',
        'state'
    ];

    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'id_semestre');
    }
    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad');
    }
    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela');
    }
}
