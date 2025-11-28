<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    use HasFactory;
    public function escuela(){
        return $this->belongsTo(Escuela::class);
    }

        public function escuelas()
    {
        return $this->hasMany(Escuela::class);
    }
    protected $table = 'facultades';

        protected $fillable = [
            'name',
            'state',
        ];

        public $timestamps = false;
}
