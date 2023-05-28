<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    public function roles() {
        return $this->belongsToMany(Role::class, 'usuario_rol')->withPivot('Estado');;
    }
}
