<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Solicitud;
use App\Models\Equipo;
use App\Models\Partido;
use App\Models\Usuario;
use App\Models\Deporte;
use Illuminate\Http\Request;

class VisualizacionController extends Controller
{
    /** Durante todo el controlador el session_start se utiliza para mantener los datos del usuario loggeado  */
    public function visualizacionDeportes()
    {
        session_start();
        /** Encuentra todos los deportes */
        $deportes['deportes'] = Deporte::all();
        /** Muestra el listado con todos los deportes */
        return view('visualizacion.index-deportes', $deportes);
    }

    public function visualizacionEquipos($id)
    {
        session_start();
        /** Obtienes todos los equipos con el id de deporte pasado en la cabecera */
        $equipos = Equipo::where('DeporteId', $id)->orderBy('PuntosTotales','desc')->get();
        $mensaje = "";
        /** Se obtiene el deporte al que pertenecen los equipos */
        $deporte = Deporte::findOrFail($id);
        /** Se muestra la vista con los equipos al deporte al que pertenecen */
        return view('visualizacion.index-equipos', compact('equipos','deporte', 'mensaje'));
    }

    public function visualizacionDatosEquipo($id)
    {
        session_start();
        /** Se obtiene el equipo al que pertenece el id pasado en la cabecera */
        $equipo = Equipo::findOrFail($id);
        /** Se obtienen los usuarios inscritos en ese deporte */
        $usuarios = DB::table('usuarios')
                ->join('usuario_equipo', 'usuarios.id', '=', 'usuario_equipo.usuario_id')
                ->where('usuario_equipo.equipo_id', '=', $id)
                ->select('usuarios.*')
                ->get();
        /** Se myuestra la vista con los datos de ese equipo */
        return view('visualizacion.datos-equipo', compact('equipo', 'usuarios'));
    }

    public function visualizacionMisEquipos($id)
    {
        session_start();
        /** Se obtiene el usuario a través del id pasado por cabecera */
        $usuario = Usuario::findOrFail($id);
        /** Se obtienen los equipos a los que está inscrito el usuario */
        $equipos = DB::table('equipos')
            ->join('usuario_equipo', 'equipos.id', '=', 'usuario_equipo.equipo_id')
            ->where('usuario_equipo.usuario_id', '=', $id)
            ->select('equipos.*')
            ->get();
        /** Se muestra una vista donde aparecen los equipos en los qiue está inscrito el usuario conectado*/
        return view('visualizacion.mis-equipos', compact('equipos', 'usuario'));
    }

    public function eliminarUsuarioEquipo($id)
    {
        session_start();
        /** Se obtiene el id del usuario loggeado */
        $idUsuario = $_SESSION['usuario_conectado']->id; 
        /** Se elimina la relacion entre el id del usuario conectado y el id del equipo pasado por la cabecera */
        DB::table('usuario_equipo')->where('equipo_id', $id)->where('usuario_id', $idUsuario)->delete();

        /** Se obtienen el resto de equipos a los que pertenece el usuario conectado */
        $equipos = DB::table('equipos')
            ->join('usuario_equipo', 'equipos.id', '=', 'usuario_equipo.equipo_id')
            ->where('usuario_equipo.usuario_id', '=', $idUsuario)
            ->select('equipos.*')
            ->get();
        /** Se muestra una vista donde aparecen los equipos en los qiue está inscrito el usuario conectado*/
        return view('visualizacion.mis-equipos', compact('equipos'));

    }

    public function visualizacionPartidos()
    {
        session_start();
        /** Se obtienen todos los partidos */ 
        $partidos['partidos'] = Partido::all();
        /** Se muestra la vista del listado de partidos */
        return view('visualizacion.resultados-partidos', $partidos);
    }
}
