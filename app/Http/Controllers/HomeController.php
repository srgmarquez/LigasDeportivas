<?php


namespace App\Http\Controllers;
use Illuminate\Session\Store;
use DB;
use App\Models\Solicitud;
use App\Models\Usuario;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** Devuelve el home de bienvenida */
        session_start();
        return view('home.index-home');
    }

    /** Método para hacer loggout */
    public function salirAplicacion()
    {
        return view('welcome');
    }
}
