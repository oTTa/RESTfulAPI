<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\Vehiculo;
use Illuminate\Http\Request;

class VehiculosController extends Controller {
       
        /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            return response()->json(['datos' => Vehiculo::all()],200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            $vehiculo = Vehiculo::find($id);
                if (!$vehiculo)
                    {
                        return response()->json(['mensaje' => "No se encuentra el Vehiculo con id=$id",'codigo' => 404],404); 
                    }
		return response()->json(['datos' => $vehiculo],200);
	}
}
