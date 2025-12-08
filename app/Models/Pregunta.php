<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    public $timestamps = false; // Porque tú estás usando date_create y date_update, no created_at/updated_at

    protected $table = 'preguntas';
    protected $fillable = [
        'pregunta',
        'id_ap',
        'state',
        'user_create',
        'user_update',
        'date_create',
        'date_update',
    ];

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }

    public function asignacion_persona() {
        return $this->belongsTo(asignacion_persona::class, 'id_ap');
    }
}
