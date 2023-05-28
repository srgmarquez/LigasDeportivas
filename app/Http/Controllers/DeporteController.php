<?php

namespace App\Http\Controllers;

use App\Models\Deporte;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeporteController extends Controller
{
    /** Durante todo el controlador el session_start se utiliza para mantener los datos del usuario loggeado  */
    public function index()
    {
        session_start();
        /** Se obtiene todos los deportes */
        $deportes['deportes'] = Deporte::all();
        /**  Se muestra la vista con el listado */
        return view('deporte.index-deporte', $deportes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        session_start();
        /** Se muestra la vista de crear un nuevo deporte */
        return view('deporte.create-deporte');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Restricciones de los campos */
        $campos = [
            'Nombre'=>'required|string|max:100',
            'Foto'=>'required|max:10000|mimes:jpeg,png,jpg',
        ];

        /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
        $mensaje = [
            'required' => "El campo :attribute es obligatorio",
            'Nombre.string' => "Elemento incorrecto en el campo 'Nombre'. Solo se admiten carácteres alfanumericos",
            'Nombre.max' => "Longitud del campo ' Nombre ' demasiado larga",
            'Foto.max' => "Foto insertada demasiado grande",
            'Foto.mimes' => "Extensión de la foto incorrecta. Solo se admiten: .JPEG .PNG .JPG"
        ];

        /** Se validarán que se cumplan todas las restricciones, en caso de que no se haga */
        /** Se reenviará a la página mostrando los errores cometidos */
        $this->validate($request, $campos, $mensaje);

        /** Se obtienen todos los valores de los campos del formulario */
        $datosDeporte = request() -> except('_token');

        /** Si ha introducido una foto  */
        if($request -> hasFile('Foto')) {
            /** Lo guarda en la siguiente carpeta  */
            $datosDeporte['Foto'] = $request -> file('Foto') -> store('uploads', 'public');
        }

        /** Inserta el deporte en la base de datos con los datos del formulario */
        Deporte::insert($datosDeporte);

        /** Redirige al listado de deportes */
        return redirect('deporte') -> with('mensaje', 'Deporte añadido con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        session_start();
        /**  Encuentra el deporte a través del id de la cabecera */
        $deporte = Deporte::findOrFail($id);
        /** Lleva a la vista de edición con los datos de ese deporte */
        return view('deporte.edit-deporte', compact('deporte'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        /** Restricciones de los campos */
        $campos = [
            'Nombre'=>'required|string|max:100',
        ];

        /** Mensajes que se mostrarán cada vez que se incumpla cada una de las restricciones */
        $mensaje = [
            'Nombre.required' => "El campo nombre es obligatorio",
            'Nombre.string' => "Elemento incorrecto en el campo 'Nombre'. Solo se admiten carácteres alfanumericos",
            'Nombre.max' => "Longitud del campo ' Nombre ' demasiado larga",
            
        ];
        /** En caso de que tenga nueva foto tendra los siguientes mensajes y restricciones */
        if($request -> hasFile('Foto')) {
            $campos = ['Foto'=>'required|max:10000|mimes:jpeg,png,jpg'];
            $mensajes = [
                'Foto.required' => "El campo fotografía es obligatorio",
                'Foto.max' => "Foto insertada demasiado grande",
                'Foto.mimes' => "Extensión de la foto incorrecta. Solo se admiten: .JPEG .PNG .JPG"
            ];
        }

        /** Se validarán que se cumplan todas las restricciones, en caso de que no se haga */
        /** Se reenviará a la página mostrando los errores cometidos */
        $this->validate($request, $campos, $mensaje);

        /** Se obtienen todos los valores de los campos del formulario */
        $datosDeporte = request() -> except(['_token','_method']);

        /** En caso de que tenga nueva foto, eliminará la anterior y guadará la nueva */
        if($request -> hasFile('Foto')) {
            $deporte = Deporte::findOrFail($id);
            Storage::delete('public/' . $deporte -> Foto);
            $datosDeporte['Foto'] = $request -> file('Foto') -> store('uploads', 'public');
        }

        /** ACtualizará el deporte */
        Deporte::where('id','=',$id)->update($datosDeporte);

        /** Y devolver al listado de deportes */
        $deporteSeleccionado = Deporte::find($id);
        $deportes['deportes'] = Deporte::paginate(10);
        return redirect('deporte') -> with('mensaje', 'Deporte "' . $deporteSeleccionado -> Nombre .'" modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        /** Se encuentre el deporte con el id proveniente de la cabecera */
        $deporte = Deporte::findOrFail($id);
        /** Se elimina la foto guardada y el deporte de la base de datos */
        if(Storage::delete('public/' . $deporte->Foto)) {
            Deporte::destroy($id);
        }
        /** Se redirige al listado de deportes */
        return redirect('deporte') -> with('mensaje', 'Deporte eliminado con éxito');
    }

    /** Obtiene los equipos a los que pertenecen a 1 deporte */
    public function equipos(){
        return $this->hasMany('App\Models\Equipo', 'DeporteId', 'id');
    }
}
