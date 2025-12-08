<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;
    protected $table = 'secciones';

    protected $fillable = [
        'name',
        'id_escuela',
        'id_semestre',
        'state',
    ];

    public function escuela() {
        return $this->belongsTo(Escuela::class, 'id_escuela');
    }

    public function semestre() {
        return $this->belongsTo(Semestre::class, 'id_semestre');
    }
}