<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Http\Controllers\DeporteController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartidoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\VisualizacionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});
Route::get('/salir-aplicacion', 'App\Http\Controllers\HomeController@salirAplicacion')->name('salir.aplicacion');

Route::resource('role', RoleController::class);
Route::resource('deporte', DeporteController::class);

Route::get('/unirse-al-equipo/{id}', 'App\Http\Controllers\EquipoController@unirseAlEquipo')->name('equipos.unirse');
Route::resource('equipo', EquipoController::class);

Route::post('/mis-equipos/eliminar/{id}', 'App\Http\Controllers\VisualizacionController@eliminarUsuarioEquipo')->name('mis.equipos.eliminate');
Route::get('/mis-equipos/{id}', 'App\Http\Controllers\VisualizacionController@visualizacionMisEquipos')->name('mis.equipos.show');
Route::get('/visualizacion-datos-equipo/{id}', 'App\Http\Controllers\VisualizacionController@visualizacionDatosEquipo')->name('datos.equipo.show');
Route::get('/visualizacion-equipos-por-deporte/{id}', 'App\Http\Controllers\VisualizacionController@visualizacionEquipos')->name('equipos.show');
Route::get('/visualizacion-deportes', 'App\Http\Controllers\VisualizacionController@visualizacionDeportes')->name('visualizacionDeportes');
Route::get('/visualizacion-partidos', 'App\Http\Controllers\VisualizacionController@visualizacionPartidos')->name('partidos.show');

Route::get('/usuario.edit-usuario', function () {
    session_start();
    $usuario = Usuario::latest('updated_at')->first();
    $_SESSION['usuario_conectado'] = $usuario;
    return view('/usuario/edit-usuario', compact('usuario'));
})->name('usuario.edit-usuario');


Route::resource('solicitud', SolicitudController::class);
Route::get('/comprobar-contraseña', 'App\Http\Controllers\UsuarioController@comprobarContraseña')->name('comprobarContraseña');
Route::resource('usuario', UsuarioController::class);
Route::resource('home', HomeController::class);


Route::resource('partido', PartidoController::class);


