<?php

namespace App\Models;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function usuarios() {
        return $this->belongsToMany(Usuario::class, 'usuario_rol')->withPivot('Estado');;
    }
}
