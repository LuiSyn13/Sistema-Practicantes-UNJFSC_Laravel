<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asignacion_persona extends Model
{
    use HasFactory;
    protected $table = 'asignacion_persona';

    protected $fillable = [
        'id_semestre',
        'id_persona',
        'id_rol',
        'id_escuela',
        'id_facultad',
        'created_at',
        'updated_at',
        'estado',
    ];
    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'id_semestre');
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
    public function rol()
    {
        return $this->belongsTo(type_users::class, 'id_rol');
    }
    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela');
    }
    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad');
    }
}
