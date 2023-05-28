<?php
namespace App\Http\Controllers;

use DB;
use App\Models\Role;
use App\Models\Usuario;
use App\Models\UsuarioRol;
use Illuminate\Http\Request;

class RoleController extends Controller
{
     /** Durante todo el controlador el session_start se utiliza para mantener los datos del usuario loggeado  */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session_start();
        /** Se obtiene todos los usuarios */
        $usuarios['usuarios'] = Usuario::all();
        /** Se devuelve el listado de los roles */
        return view('roles.index-roles', $usuarios);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /** Se obtienen los valors del formulario */
        $usuario =  $request->input('usuario_id');
        $role =  $request->input('role_id');
        $estado =  $request->input('estado');

        /** en caso de que se halla activado se cambiará si no quedará como esta */
        $nuevoEstado = 0;
        if($estado == 0) {
            $nuevoEstado = 1;
        }

        /** Se obtendrá el usuario a través del formulario */
        $user = Usuario::find($usuario);
        /** Se modifica el estado de una tabla pivot */
        $user->roles()->updateExistingPivot($role, ['Estado' =>  $nuevoEstado]);
        
        session_start();
        $usuarios['usuarios'] = Usuario::all();
        /** Se redirige al listado de roles */
        return view('roles.index-roles', $usuarios);
    }
}