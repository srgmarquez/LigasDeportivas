<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Partido;
use App\Models\Deporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PartidoController extends Controller
{
    /** Durante todo el controlador el session_start se utiliza para mantener los datos del usuario loggeado  */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session_start();
        /** Se obtiene todos los partidos */
        $partidos['partidos'] = Partido::all();
        /**  Se muestra la vista con el listado */
        return view('partido.index-partido', $partidos);    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        session_start();
        /** Se obtienen todos los equipos */
        $equipos = Equipo::all();
        /** Se muestra la vista de crear un nuevo partido */
        return view('partido.create-partido',compact('equipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Se obtienen todos los valores del formulario */
        $data = $request->all();

        /** Se crea un contador para saber si se han introducido los dos equipos */
        $contador = 0;

        /** Se obtienen los id de los dos equipos */
        $idEquipoLocal     = $request->input('equipoLocal');
        $idEquipoVisitante = $request->input('equipoVisitante');
        
        /** En caso de que hallan elegido un equipo */
        if($idEquipoLocal != "Seleccionar un equipo"){
            /** Se obtendrá el equipo y se sumará 1 al contador para que se entienda que ha elegido un equipo */
            $equipoLocal     = Equipo::findOrFail($idEquipoLocal);
            $contador++;
        }
        if($idEquipoVisitante != "Seleccionar un equipo"){
            $equipoVisitante = Equipo::findOrFail($idEquipoVisitante);
            $contador++;
        }


        /** Comprobación de que ha elegido los dos equipos */
        if($contador == 2){

            // Si los equipos tienen diferente deporte 
            if($equipoLocal->DeporteId != $equipoVisitante->DeporteId){               
                /** Restricciones de los campos */
                $rules = [
                    'equipoLocal'=>'required',
                    'equipoVisitante'=>'required|mismo_deporte:equipoLocal',
                    'FechaPartido'=>'required|after:today',
                ];
                /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
                $messages = [
                    'required' => "El campo :attribute es obligatorio",
                    'mismo_deporte' =>"Ambos equipo deben pertenecer al mismo deporte",
                    'after' => 'La fecha debe ser posterior a la fecha actual.',
                ];
                /** Si los equipos seleccionados son el mismo */
            } else if($equipoLocal->id == $equipoLocal->id) {
                /** Restricciones de los campos */
                $rules = [
                    'equipoLocal'=>'required',
                    'equipoVisitante'=>'required|diferentes_equipos:equipoLocal',
                    'FechaPartido'=>'required|after:today',
                ];
                /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
                $messages = [
                    'required' => "El campo :attribute es obligatorio",
                    'diferentes_equipos' => 'No selecciones el mismo equipo dos veces.',
                    'after' => 'La fecha debe ser posterior a la fecha actual.',
                ];


            } 
            /** En caso de que no halla elegido un equipo */
        } else {
            /** Restricciones de los campos */
            $rules = [
                'equipoLocal'=>'required|not_in:Seleccionar un equipo',
                'equipoVisitante'=>'required|not_in:Seleccionar un equipo',
                'FechaPartido'=>'required|after:today',
            ];
            /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
            $messages = [
                'not_in' => "El campo :attribute es obligatorio",
                'FechaPartido.required' => "El campo fecha es obligatorio",
                'after' => 'La fecha debe ser posterior a la fecha actual.',
            ];
        }

        try {
            // Validará los campos a través de las reglas 
            $validator = Validator::make($data, $rules, $messages);
            $validator->validate();
        } catch (ValidationException $e) {
            // En caso de que enucntre errores los mostrará
            $errors = $e->validator->errors();
            return redirect()->back()->withErrors($errors)->withInput();
        }
        /** Obtendrá todos los datos del formulario */
        $datosPartido = request() -> except('_token');

        /** Creará el nuevo partido en la base de datos y redirigirá al listado de partidos */
        Partido::insert($datosPartido);
        return redirect('partido')-> with('mensaje', 'Partido añadido con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        session_start();
        /**  Encuentra el partido a través del id de la cabecera */
        $partido = Partido::findOrFail($id);
        /** Obtiene todos los equipos  */
        $equipos = Equipo::all();
        /** Lleva a la vista de edición con los datos de ese partido */
        return view('partido.edit-partido', compact('partido','equipos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        /** Se obtienen todos los valores del formulario */
        $data = $request->all();

        /** Se crea un contador para saber si se han introducido los dos equipos */
        $contador = 0;

        /** Se obtienen los id de los dos equipos */
        $idEquipoLocal     = $request->input('equipoLocal');
        $idEquipoVisitante = $request->input('equipoVisitante');
        
        /** En caso de que hallan elegido un equipo */
        if($idEquipoLocal != "Seleccionar un equipo"){
            /** Se obtendrá el equipo y se sumará 1 al contador para que se entienda que ha elegido un equipo */
            $equipoLocal     = Equipo::findOrFail($idEquipoLocal);
            $contador++;
        }
        if($idEquipoVisitante != "Seleccionar un equipo"){
            $equipoVisitante = Equipo::findOrFail($idEquipoVisitante);
            $contador++;
        }

        /** Comprobación de que ha elegido los dos equipos */
        if($contador == 2){
            // Si los equipos tienen diferente deporte 
            if($equipoLocal->DeporteId != $equipoVisitante->DeporteId){
                /** Restricciones de los campos */
                $rules = [
                    'equipoLocal'=>'required',
                    'equipoVisitante'=>'required|mismo_deporte:equipoLocal',
                    'FechaPartido'=>'required|after:today',
                ];
                /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
                $messages = [
                    'required' => "El campo :attribute es obligatorio",
                    'mismo_deporte' =>"Ambos equipo deben pertenecer al mismo deporte",
                    'after' => 'La fecha debe ser posterior a la fecha actual.',
                ];
                /** Si los equipos seleccionados son el mismo */
            } else if($equipoLocal->id == $equipoLocal->id) {
                /** Restricciones de los campos */
                $rules = [
                    'equipoLocal'=>'required',
                    'equipoVisitante'=>'required|diferentes_equipos:equipoLocal',
                    'FechaPartido'=>'required|after:today',
                ];
                /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
                $messages = [
                    'required' => "El campo :attribute es obligatorio",
                    'diferentes_equipos' => 'No selecciones el mismo equipo dos veces.',
                    'after' => 'La fecha debe ser posterior a la fecha actual.',
                ];


            } 
            /** En caso de que no halla elegido un equipo */
        } else {
            /** Restricciones de los campos */
            $rules = [
                'equipoLocal'=>'required|not_in:Seleccionar un equipo',
                'equipoVisitante'=>'required|not_in:Seleccionar un equipo',
                'FechaPartido'=>'required|after:today',
            ];
            /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
            $messages = [
                'not_in' => "El campo :attribute es obligatorio",
                'FechaPartido.required' => "El campo fecha es obligatorio",
                'after' => 'La fecha debe ser posterior a la fecha actual.',
            ];
        }

        try {
            // Validará los campos a través de las reglas 
            $validator = Validator::make($data, $rules, $messages);
            $validator->validate();
        } catch (ValidationException $e) {
            // En caso de que enucntre errores los mostrará
            $errors = $e->validator->errors();
            return redirect()->back()->withErrors($errors)->withInput();
        }
        /** Obtendrá todos los campos del formulario */
        $datosDeporte = request() -> except(['_token','_method']);

        /** ACtualizará los campos del partido */
        Partido::where('id','=',$id)->update($datosDeporte);
        Partido::where('id', $id)->update(['Estado' => 'Finalizado']);

        /** Se obtendrá los goles de los dos equipos */
        $golesLocal = $request->input('GolesEquipoLocal');
        $golesVisitante = $request->input('GolesEquipoVisitante');
       
        /** En caso de que el local halla ganado */
        if($golesLocal > $golesVisitante)
        {
            /** Se le sumará un partido ganado al equipo local */
            $partidosGanadosLocal = $equipoLocal->PartidosGanados;
            $partidosGanadosLocal = $partidosGanadosLocal + 1;

            /** Se le sumará un partido perdido al equipo visitante */
            $partidosPerdidosVisitante = $equipoVisitante->PartidosPerdidos;
            $partidosPerdidosVisitante = $partidosPerdidosVisitante + 1;

            /** Se le sumarán 3 a los puntos totales al equipo local */
            $puntosTotalesLocal = $equipoLocal->PuntosTotales;
            $puntosTotalesLocal = $puntosTotalesLocal + 3;

            /** Se actualizará en la base de datos */
            Equipo::where('id', $idEquipoLocal )->update(['PartidosGanados' => $partidosGanadosLocal,'PuntosTotales' => $puntosTotalesLocal]);
            Equipo::where('id', $idEquipoVisitante )->update(['PartidosPerdidos' => $partidosPerdidosVisitante]);
        
            /** En caso de que el eqipo visitante halla ganado */
        } else if($golesLocal < $golesVisitante)
        {
            /** Se le sumará un partido ganado al equipo visitante */
            $partidosGanadosVisitante = $equipoVisitante->PartidosGanados;
            $partidosGanadosVisitante = $partidosGanadosVisitante + 1;

            /** Se le sumará un partido perdido al equipo local */
            $partidosPerdidosLocal = $equipoLocal->PartidosPerdidos;
            $partidosPerdidosLocal = $partidosPerdidosLocal + 1;

            /** Se le sumarán 3 a los puntos totales al equipo visitante */
            $puntosTotalesVisitante = $equipoVisitante->PuntosTotales;
            $puntosTotalesVisitante = $puntosTotalesVisitante + 3;

            /** Se actualizará en la base de datos */
            Equipo::where('id', $idEquipoLocal )->update(['PartidosPerdidos' => $partidosPerdidosLocal]);
            Equipo::where('id', $idEquipoVisitante )->update(['PartidosGanados' => $partidosGanadosVisitante,'PuntosTotales' => $puntosTotalesVisitante]);
            
            /** En caso de que hallan empatado */
        } else if($golesLocal = $golesVisitante)
        {
            /** Se le sumará un partido empatado al equipo visitante */
            $partidosEmpatadosVisitante = $equipoVisitante->PartidosEmpatados;
            $partidosEmpatadosVisitante = $partidosEmpatadosVisitante + 1;

            /** Se le sumará un partido empatado al equipo local */
            $partidosEmpatadosLocal = $equipoLocal->PartidosEmpatados;
            $partidosEmpatadosLocal = $partidosEmpatadosLocal + 1;

            /** Se le sumará 1 a los puntos totales al equipo visitante */
            $puntosTotalesVisitante = $equipoVisitante->PuntosTotales;
            $puntosTotalesVisitante = $puntosTotalesVisitante + 1;

            /** Se le sumará 1 a los puntos totales al equipo local */
            $puntosTotalesLocal = $equipoLocal->PuntosTotales;
            $puntosTotalesLocal = $puntosTotalesLocal + 1;

            /** Se actualizará en la base de datos */
            Equipo::where('id', $idEquipoLocal )->update(['PartidosEmpatados' => $partidosEmpatadosLocal,'PuntosTotales' => $puntosTotalesLocal]);
            Equipo::where('id', $idEquipoVisitante )->update(['PartidosEmpatados' => $partidosEmpatadosVisitante,'PuntosTotales' => $puntosTotalesVisitante]);
        }

        /** Se le suma 1 a los partidos jugados al equipo visitante */
        $partidosTotalesVisitante = $equipoVisitante->PartidosTotales;
        $partidosTotalesVisitante = $partidosTotalesVisitante + 1;

        /** Se le suma 1 a los partidos jugados al equipo local */
        $partidosTotalesLocal = $equipoLocal->PartidosTotales;
        $partidosTotalesLocal = $partidosTotalesLocal + 1;

        /** Se actualizá en la base de datos */
        Equipo::where('id', $idEquipoLocal )->update(['PartidosJugados' => $partidosTotalesLocal]);
        Equipo::where('id', $idEquipoVisitante )->update(['PartidosJugados' => $partidosTotalesVisitante]);

        /** Se redirige al listado de partidos */
        return redirect('partido') -> with('mensaje', 'Resultado del partido colocado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        /** Se encuentre el partido con el id proveniente de la cabecera */
        $partido = Partido::findOrFail($id);
        Partido::destroy($id);      
        /** Se redirige al listado de partidos */ 
        return redirect('partido') -> with('mensaje', 'Partido eliminado con éxito');
    }

}
