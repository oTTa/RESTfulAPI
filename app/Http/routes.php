<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*SE EJECUTAN DE MANERA SECUENCIAL POR ESO ES IMPORTANTE EL ORDEN. */
Route::group(array('prefix' => 'api/v1'), function ()
{
    Route::resource('vehiculos','VehiculosController', ['only' => [ 'index', 'show']]);
    Route::resource('fabricantes', 'FabricanteController', ['except' => ['edit', 'create']]);
    Route::resource('fabricantes.vehiculos', 'FabricanteVehiculosController',['except' => ['show', 'edit', 'create']]);
});    

/*ATRAPA LOS DEMAS ROUTEOS QUE SERIAN INCORRECTOS*/
Route::pattern('inexistente', '.*');//EXPRESION REGULAR (.*), ATRAPA TODO
Route::any('/{inexistentes}',function(){
    return response()->json(['mensaje' => "Ruta y/o metodo incorrectos",'codigo' => 400],400); 
});   