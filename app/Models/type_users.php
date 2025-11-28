<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_users extends Model
{
    use HasFactory;

    protected $table = 'type_users';
    protected $fillable = [
        'name', 'state'
    ];

    public function personas()
    {
        return $this->hasMany(Persona::class);
    }
}
