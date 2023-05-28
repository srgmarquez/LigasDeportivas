<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Usuario;
use App\Models\Equipo;
use App\Models\Deporte;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    /** Durante todo el controlador el session_start se utiliza para mantener los datos del usuario loggeado  */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session_start();
        /** Se obtiene todas las solicitudes */
        $solicitudes['solicitudes'] = Solicitud::all();
        /** Se devuelve el listado de las solicitudes */
        return view('solicitud.index-solicitud', $solicitudes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        session_start();
        $equipo = new Equipo();
        /** se obtienes todos los deportes */
        $deportes = Deporte::all();
        /** Se muestra la vista de crear un nuevo equipo */
        return view('equipo.create-equipo', compact('equipo','deportes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        session_start();
        /** Restricciones de los campos */
        $campos = [
            'NombreEquipo'=>'required|string|max:100',
            'FotoEquipo'=>'required|max:10000|mimes:jpeg,png,jpg',
        ];

        /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
        $mensaje = [
            'NombreEquipo.required' => "El campo Nombre es obligatorio",
            'FotoEquipo.required' => "El campo Escudo es obligatorio",
            'NombreEquipo.string' => "Elemento incorrecto en el campo 'Nombre'. Solo se admiten carácteres alfanumericos",
            'NombreEquipo.max' => "Longitud del campo ' Nombre ' demasiado larga",
            'FotoEquipo.max' => "Foto insertada demasiado grande",
            'FotoEquipo.mimes' => "Extensión de la foto incorrecta. Solo se admiten: .JPEG .PNG .JPG"
        ];

        /** Se validarán que se cumplan todas las restricciones, en caso de que no se haga */
        /** Se reenviará a la página mostrando los errores cometidos */
        $this->validate($request, $campos, $mensaje);

        /** Se obtienen los valores de los campos del formulario */
        $nombreEquipo = $request->input('NombreEquipo');
        $escudoEquipo = $request->input('FotoEquipo');
        $deporteEquipo = $request->input('DeporteId');

        /** Se obtiene el id del usuario conectado */
        $idUsuario = $_SESSION['usuario_conectado']->id;


        $datosEquipo = request() -> except('_token');
        /** Se guarda la foto de la solicitud del equipo */
        $datosEquipo['FotoEquipo'] = $request -> file('FotoEquipo') -> store('uploads', 'public');

        /** Se inserta len la base de datos la solicitud */
        DB::table('solicituds')->insert([
            'NombreEquipo' => $nombreEquipo,
            'FotoEquipo' => $datosEquipo['FotoEquipo'],
            'Deporte' => $deporteEquipo,
            'UsuarioId' => $idUsuario,
        ]);

        /** Se redirige a la vista del listado de solicitudes */
        return redirect('solicitud/create') -> with('mensaje', 'Solicitud enviada con éxito');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        session_start();
        /** Se obtiene la solicitud a través del id pasado por la cabecera  */
        $solicitud = Solicitud::findOrFail($id);
        /** Se obtiene el usuario y el deporte al que pertenecen esas solicitud */
        $usuario = Usuario::find($solicitud->UsuarioId);
        $deporte = Deporte::find($solicitud->Deporte);
        /** Se visualiza la vista del formulario de edición de solicitudes con sus datos */
        return view('solicitud.edit-solicitud', compact('solicitud', 'usuario', 'deporte'));
    }
}
