<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Equipo;
use App\Models\Deporte;
use App\Models\Solicitud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class EquipoController extends Controller
{
    /** Durante todo el controlador el session_start se utiliza para mantener los datos del usuario loggeado  */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session_start();
        /** Se obtiene todos los equipos */
        $equipos['equipos'] = Equipo::all();
         /**  Se muestra la vista con el listado */
        return view('equipo.index-equipo', $equipos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Si el profesor ha decidido aceptar la solicitud */
        if ($request->has('botonAceptar')) {
            /** Se obtienen los valores del campo del formulario */
            $nombreEquipo =  $request->input('NombreEquipo');
            $fotoEquipo = $request->input('FotoEquipo');
            $deporte = $request->input('DeporteId');
            $capitan = $request->input('Capitan');

            /** Se crea el equipo  */
            $idEquipo = DB::table('equipos')->insertGetId([
                'NombreEquipo' => $nombreEquipo,
                'FotoEquipo' => $fotoEquipo,
                'DeporteId' => $deporte,
                'Capitan' => $capitan,
            ]);

            /** Se guardan los valores en la tabla pivot */
            DB::table('usuario_equipo')->insert([
                'usuario_id' => $capitan,
                'equipo_id' => $idEquipo,
            ]);

            /** Se obtiene el id de la solicitud y se actualiza  */
            $solicitudId = $request->input('SolicitudId');
            $solicitud = Solicitud::find($solicitudId);
            $solicitud->fill([
                'EstadoSolicitud' => 1,
                'ResolucionSolicitud' => 'Aprobada',
            ]); 
            /** Se guarda y se redirige al listado de solicitudes */
            $solicitud->save();

            return redirect('solicitud') -> with('mensaje', 'Equipo añadido con éxito');

        /** En caso de que el profesor deniegue la solicitud */
        } elseif ($request->has('botonRechazar')) {    
            /** Se obtiene el id de la solicitud y se actualiza como denegada */  
            $solicitudId = $request->input('SolicitudId');
            $solicitud = Solicitud::find($solicitudId);
            $solicitud->fill([
                'EstadoSolicitud' => 1,
                'ResolucionSolicitud' => 'Denegada',
            ]); 
            /** Se guarda y se redirige al al listado de solicitudes */
            $solicitud->save();
            return redirect('solicitud') -> with('mensaje', 'Equipo añadido con éxito');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        /** Se obtiene el equipo que se va a editar por el id */
        $equipo = Equipo::findOrFail($id);
        /** Se obtienen todos los deportes */
        $deportes = Deporte::all();
        /** Se muestra la vista de edicion de equipos */
        return view('equipo.edit-equipo', compact('equipo','deportes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        /** Restricciones de los campos */
        $campos = [
            'NombreEquipo'=>'required|string|max:100',
        ];

        /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
        $mensaje = [
            'Nombre.required' => "El campo Nombre es obligatorio",
            'Nombre.string' => "Elemento incorrecto en el campo 'Nombre'. Solo se admiten carácteres alfanumericos",
            'Nombre.max' => "Longitud del campo ' Nombre ' demasiado larga",     
        ];

        /** En caso de que tenga nueva foto tendra los siguientes mensajes y restricciones */
        if($request -> hasFile('FotoEquipo')) {
            $campos = ['FotoEquipo'=>'required|max:10000|mimes:jpeg,png,jpg'];
            $mensajes = [
                'FotoEquipo.required' => "El campo Escudo es obligatorio",
                'FotoEquipo.max' => "Escudo insertado demasiado grande",
                'FotoEquipo.mimes' => "Extensión del escudo incorrecta. Solo se admiten: .JPEG .PNG .JPG"
            ];
        }

        /** Se validarán que se cumplan todas las restricciones, en caso de que no se haga */
        /** Se reenviará a la página mostrando los errores cometidos */
        $this->validate($request, $campos, $mensaje);

        /** Se obtienen todos los valores de los campos del formulario */
        $datosEquipo = request() -> except(['_token','_method']);

        /** En caso de que tenga nueva foto, eliminará la anterior y guadará la nueva */
        if($request -> hasFile('FotoEquipo')) {
            $equipo = Equipo::findOrFail($id);
            Storage::delete('public/' . $equipo -> FotoEquipo);
            $datosEquipo['FotoEquipo'] = $request -> file('FotoEquipo') -> store('uploads', 'public');
        }

         /** ACtualizará el equipo */
        Equipo::where('id','=',$id)->update($datosEquipo);

        /** Redirigirá a la pagina de listado de equipos */
        $equipoSeleccionado = Equipo::find($id);
        $equipos['equipos'] = Equipo::all();
        return redirect('equipo') -> with('mensaje', 'Equipo "' . $equipoSeleccionado -> NombreEquipo .'" modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        /** Se encuentre el equipo con el id proveniente de la cabecera */
        $equipo = Equipo::findOrFail($id);
        /** Se elimina la foto guardada y el deporte de la base de datos */
        if(Storage::delete('public/' . $equipo->FotoEquipo)) {
            Equipo::destroy($id);
        }
         /** Se redirige al listado de equipos */
        return redirect('equipo') -> with('mensaje', 'Equipo eliminado con éxito');
    }

    public function unirseAlEquipo($id)
    {
        // Se obtiene el id del usuario que es el que esta conectado a través de la sesión
        session_start();
        $idUsuario = $_SESSION['usuario_conectado']->id;

        // Se inserta en la tabla que relaciona a los usuarios con los equipos
        // pero primero se comprueba que no este ya en el equipo (al hacer F5 en la página se añadía más veces
        // el usuario con ese equipo)
        $cantidad = DB::table('usuario_equipo') ->where('equipo_id', '=', $id)->where('usuario_id', '=', $idUsuario)->count(); 
        if($cantidad < 1) {
            DB::table('usuario_equipo')->insert([
                'usuario_id' => $idUsuario,
                'equipo_id' => $id,
            ]);
        }

        // Obtenemos el equipo al que pertenece el id que se pasa como parámetro 
        $equipo  = Equipo::findOrFail($id);

        // Obtenemos el deporte al que pertenece ese equipo
        $deporte = Deporte::findOrFail($equipo->DeporteId);

        // Obtenemos los equipos que pertenecen a ese deporte
        $equipos = Equipo::where('DeporteId', $deporte->id)->get();

        // Mensaje de validación
        $mensaje = "Añadido al equipo '" . $equipo->NombreEquipo . "' con éxito";

        //Volvemos a la vista que carguen todos los equipos de un deporte
        return view('visualizacion.index-equipos', compact('equipos','deporte','mensaje'));    
    }

    /** Método que encuentra el deporte al que pertenece ese equipo */
    public function deporte() {
        return $this->belongsTo(Deporte::class);
    }
    
}
