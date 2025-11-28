<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
    'id_persona',
    'pregunta_id',
    'respuesta',
    'user_create',
    'user_update',
    'date_create',
    'date_update',
    'state',
];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

}
