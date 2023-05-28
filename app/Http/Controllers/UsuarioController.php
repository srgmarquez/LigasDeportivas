<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Role;
use Illuminate\Session\Store;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use DB;

class UsuarioController extends Controller
{
    /** Durante todo el controlador el session_start se utiliza para mantener los datos del usuario loggeado  */
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** Se visualiza la vista de registro de la aplicación */
        return view('usuario.create-usuario');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         /** Restricciones de los campos */
        $validator =  [
            'password' => [
                'required',// debe ser obligatorio
                Password::min(8) // larguna mínima de 8 carácteres
                    ->mixedCase() // al menos una letra mayúscula y una letra minúscula
                    ->numbers() // al menos un númerico
                    ->symbols() // al menos un carácter especial               
            ],
            'NombreUsuario'=>'required|string|max:100',
            'email'=>'required',
            'Curso'=>'required|string|max:100',
            'FotoUsuario'=>'max:10000|mimes:jpeg,png,jpg',
        ]; 

        /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
        $mensaje = [
            'password.required' => "El campo ' Contraseña' es obligatorio",
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.mixed_case' => 'La contraseña debe contener al menos una letra mayúscula y una letra minúscula.',
            'password.numbers' => 'La contraseña debe contener al menos un número.',
            'password.symbols' => 'La contraseña debe contener al menos un carácter especial.',
            'NombreUsuario.string' => "Elemento incorrecto en el campo 'Nombre'. Solo se admiten carácteres alfanumericos",
            'NombreUsuario.max' => "Longitud del campo ' Nombre ' demasiado larga",
            'FotoUsuario.max' => "'Fotografía ' insertada demasiado grande",
            'FotoUsuario.mimes' => "Extensión de la foto incorrecta. Solo se admiten: .JPEG .PNG .JPG",
            'NombreUsuario.required' => "El campo ' Nombre ' es obligatorio",
            'email.required' => "El campo ' Email ' es obligatorio",
            'Curso.string' => "Elemento incorrecto en el campo ' Curso '. Solo se admiten carácteres alfanumericos",
            'Curso.max' => "Longitud del campo ' Curso ' demasiado larga",
            'Curso.required' => "El campo ' Curso ' es obligatorio",
        ];
        
        /** Se validarán que se cumplan todas las restricciones, en caso de que no se haga */
        /** Se reenviará a la página mostrando los errores cometidos */
        $this->validate($request, $validator, $mensaje);
        $datosUsuario = request() -> except('_token');

        /** Se obtiene el valor de la contraseña del formulario */
        $password =  $request->input('password');
        /** Se codifica para que en la base de datos nos e vea el valor de la contraseña */
        $datosUsuario['password'] = Hash::make($password);

        /** En caso de que halla introducido foto */
        if($request -> hasFile('FotoUsuario')) {
            /** Se guardará en la carpeta */
            $datosUsuario['FotoUsuario'] = $request -> file('FotoUsuario') -> store('uploads', 'public');
        }
        /** Se inserta el usuario en la base de datos */
        Usuario::insert($datosUsuario);

        /** Se obtiene el usuario que se acaba de insertar */
        $usuario = DB::table('usuarios')->orderBy('created_at', 'desc')->first();

        /** Se le asignan los roles por defecto es decir; solo va a tener el rol de alumno */
        DB::table('usuario_rol')->insert([
            'usuario_id' => $usuario->id,
            'role_id' => 1,
            'Estado' => 0,
        ]);

        DB::table('usuario_rol')->insert([
            'usuario_id' => $usuario->id,
            'role_id' => 2,
            'Estado' => 0,
        ]);

        DB::table('usuario_rol')->insert([
            'usuario_id' => $usuario->id,
            'role_id' => 3,
            'Estado' => 1,
        ]); 
        /** Por último se le redirige  al home de bienvenida*/
        session_start();
        $_SESSION['usuario_conectado'] = $usuario;
        return redirect('/home') -> with('mensaje', 'Te has registrado correctamente.');
    }

    /** Método para cuando un usuario se loggea, se comprueba que las credenciales estan bién */
    public function comprobarContraseña(Request $request){
        /** Se obtiene el valor de la contraseña y del email del formulario*/  
        $password = $request->input('password');
        $email = $request->input('email');
        /** se obtiene el valor que tendria que tener la contraseña del usuario a través del email */
        $hashedPassword = DB::table('usuarios')->where('email', $email)->value('password');
        /** Se comprueba con la introducida por el usuario */
        if (Hash::check($password, $hashedPassword)) {
            session_start();
            /** En caso de que coincidan se creará una sesión con el fin de guardar el usuario conectado y
             * se le redirigirá al home de bienvenida
             */
            $usuario = Usuario::where('email', $email)->first();
            $_SESSION['usuario_conectado'] = $usuario;
            return redirect('/home');
        } else {
            /** En caso de que introduzca mal alguno de los dos credenciales le redirigira a la página de inicio
             * con un mensaje informandole de que a introducio mal el correo o la contraseña
             */
            return redirect('/') -> with('mensaje', 'Correo o contraseña mal introducidos.');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        session_start();
         /**  Encuentra el usuario a través del id de la cabecera */
        $usuario = Usuario::findOrFail($id);
         /** Lleva a la vista de edición con los datos de ese usuario */
        return view('usuario.edit-usuario', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        /** Restricciones de los campos */
        $campos = [
            'NombreUsuario'=>'required|string|max:100',
            'email'=>'required',
            'Curso'=>'required|string|max:100',
        ];

        /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
        $mensaje = [    
            'NombreUsuario.string' => "Elemento incorrecto en el campo 'Nombre'. Solo se admiten carácteres alfanumericos",
            'NombreUsuario.max' => "Longitud del campo ' Nombre ' demasiado larga",
            'NombreUsuario.required' => "El campo ' Nombre ' es obligatorio",
            'email.required' => "El campo ' Email ' es obligatorio",
            'Curso.string' => "Elemento incorrecto en el campo ' Curso '. Solo se admiten carácteres alfanumericos",
            'Curso.max' => "Longitud del campo ' Curso ' demasiado larga",
            'Curso.required' => "El campo ' Curso ' es obligatorio",          
        ];

        /** En caso de que tenga nueva foto tendra los siguientes mensajes y restricciones */
        if($request -> hasFile('FotoUsuario')) {
            $campos = ['FotoUsuario'=>'required|max:10000|mimes:jpeg,png,jpg'];
            $mensajes = [
                'FotoUsuario.required' => "El campo fotografía es obligatorio",
                'FotoUsuario.max' => "Foto insertada demasiado grande",
                'FotoUsuario.mimes' => "Extensión de la foto incorrecta. Solo se admiten: .JPEG .PNG .JPG"
            ];
        }

        /** Se validarán que se cumplan todas las restricciones, en caso de que no se haga */
        /** Se reenviará a la página mostrando los errores cometidos */
        $datosUsuario = request() -> except(['_token','_method']);


        session_start();
        /** se obtiene el id del usuario conectado  */
        $idUsuario = $_SESSION['usuario_conectado']->id;

        /** posteriormente el usuario */
        $usuario = Usuario::findOrFail($idUsuario);
        /** En caso de que el usuario quiera editar la foto se eliminará la anterior y se guardará la nueva */
        if($request -> hasFile('FotoUsuario')) {
            Storage::delete('public/' . $usuario -> FotoUsuario);
            $datosUsuario['FotoUsuario'] = $request -> file('FotoUsuario') -> store('uploads', 'public');
        }
        /** En casi de que el usuario quiera cambiar la contraseña  */
        if ($request->filled('password')) {
            $campos = [
                'password' => [
                    'required',// debe ser obligatorio
                    Password::min(8) // larguna mínima de 8 carácteres
                        ->mixedCase() // al menos una letra mayúscula y una letra minúscula
                        ->numbers() // al menos un númerico
                        ->symbols() // al menos un carácter especial               
                ],
            ];

            $mensaje = [
                'password.required' => "El campo ' Contraseña' es obligatorio",
                'password.min' => 'La contraseña debe tener al menos :min caracteres.',
                'password.mixed_case' => 'La contraseña debe contener al menos una letra mayúscula y una letra minúscula.',
                'password.numbers' => 'La contraseña debe contener al menos un número.',
                'password.symbols' => 'La contraseña debe contener al menos un carácter especial.',
            ];
            $datosUsuario['password'] = Hash::make($request->input('password'));
        } else {
            unset($datosUsuario['password']);
        }
        /** Se validarán estos ultimos  campos */
        $this->validate($request, $campos, $mensaje);
        /** Se actualizará el usuario en la base de datos */
        Usuario::where('id','=',$idUsuario)->update($datosUsuario);
        /** Se obtendrá el usuario actualizado y se le redirigirá a la página de edición de su perfil */
        $usuario_actualizado = Usuario::findOrFail($idUsuario);
        return redirect()->route('usuario.edit-usuario', ['usuario' => $usuario_actualizado])->with('mensaje', 'Usuario modificado con éxito');
    }
}
