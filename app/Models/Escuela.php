<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    use HasFactory;

    public function facultad(){
        return $this->belongsTo(\App\Models\Facultad::class, 'facultad_id');
    }
    

    protected $fillable = [
        'name', 
        'facultad_id',
        'state'
    ];
    
    /**
     * Define la relación "una a muchas" con Seccion.
     * Una Escuela puede tener muchas Secciones.
     */
    public function secciones()
    {
        return $this->hasMany(\App\Models\Seccion::class, 'id_escuela');
    }

    public function sa() {
        return $this->hasMany(seccion_academica::class, 'id_escuela');
    }

    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela'); // o el nombre real de tu clave foránea
    }


}
