<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource("inmuebles", "HomeController");
Route::resource("home", "HomeController"); 
Route::resource("caracteristicas", "CaracteristicaController");
Route::resource("inmobiliarias", "InmobiliariaController");
Route::resource("pais", "PaiController");
Route::resource("ciudad", "CiudadController");
Route::resource("planes", "PlanController");
Route::resource("pagos", "PagoController");
Route::resource("demandas", "DemandaController");
Route::resource("comentarios", "ComentarioController");
Route::resource("reportes", "ReporteController");
Route::resource("favoritos", "FavoritoController");
Route::resource("usuarios", "UserController");

Route::post("login", "Api\Auth\LoginController@login");

Route::group(['middleware'=> 'auth'], function(){
Route::post("logout", "Api\Auth\LoginController@logout");
});

Route::group(['middleware'=> 'cors'], function(){
//Recursos admin inicio//
Route::get('Adminpaises', "AngularAdminControllerPais@paises");
Route::get('Admincomentarios', "AngularAdminControllerComentarios@comentarios");
Route::get('Admininmuebles', "AngularAdminControllerInmueble@inmuebles");
Route::get('Admindemandas', "AngularAdminControllerDemandas@demandas");
Route::get('Adminreportes', "AngularAdminControllerReportes@reportes");
Route::get('Adminciudades', "AngularAdminControllerCiudad@ciudad");
Route::get('Admintipos', "AngularAdminControllerTipo@tipo");
Route::get('AdminFormapagos', "AngularAdminControllerFormaPagos@Formapagos");
Route::get('AdminPlanes', "AngularAdminControllerPlanes@plan");
Route::get('Adminuser', "AngularAdminControllerUser@user");

});