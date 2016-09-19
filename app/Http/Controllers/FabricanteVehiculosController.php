<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Vehiculo;
use App\Fabricante;
use Illuminate\Http\Request;

class FabricanteVehiculosController extends Controller {
    
        public function __construct() {
            $this->middleware('auth.basic.once',['only' => ['store','update','destroy']]);
        }
    
        /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$fabricante = Fabricante::find($id);
                if (!$fabricante)
                    {
                        return response()->json(['mensaje' => "No se encuentra el fabricante con id=$id",'codigo' => 404],404); 
                    }
		return response()->json(['datos' => $fabricante->vehiculos()->get()],200);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request, $id)
	{
            if (!$request->input('color') || !$request->input('cilindraje') || !$request->input('potencia') || !$request->input('peso'))
            {
                return response()->json(['mensaje' => 'No se pudieron procesar los valores','codigo' => 422],422);
            }
            $fabricante = Fabricante::find($id);
            if (!$fabricante)
            {
                return response()->json(['mensaje' => 'No existe el fabricante','codigo' => 404],404);
            }
            $fabricante->vehiculos()->create($request->all());
            return response()->json(['mensaje' => 'Vehiculo insertado.'],200);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $idFabricante, $idVehiculo)
	{
	    $metodo = $request->method();
            $fabricante = Fabricante::find($idFabricante);
            if (!$fabricante)
            {
                return response()->json(['mensaje' => "No se encuentra el fabricante con id=$idFabricante",'codigo' => 404],404);  
            }
            
            $vehiculo = $fabricante->vehiculos()->find($idVehiculo);
            
            if (!$vehiculo)
            {
                return response()->json(['mensaje' => "No se encuentra el vehiculo con id=$idVehiculo asociado al fabricante id=$idFabricante",'codigo' => 404],404);  
            }
            
            $color = $request->input('color');
            $cilindraje = $request->input('cilindraje');
            $peso = $request->input('peso');
            $potencia = $request->input('potencia');
            if ($metodo === 'PATCH')
            {   
                $flag=false;
                
                if ($color!=null && $color!=''){
                    $vehiculo->color = $color;
                    $flag=true;
                }
                
                
                if ($cilindraje!=null && $cilindraje!=''){
                    $vehiculo->cilindraje = $cilindraje;
                    $flag=true;
                }
                
                
                if ($peso!=null && $peso!=''){
                    $vehiculo->peso = $peso;
                    $flag=true;
                }
                
                if ($potencia!=null && $potencia!=''){
                    $vehiculo->potencia = $potencia;
                    $flag=true;
                }
                
                if ($flag){
                    $vehiculo->save();
                    return response()->json(['mensaje' => 'vehiculo actualizado'],200);
                }
                else{
                    return response()->json(['mensaje' => 'todos los parametros son nulos o vacios, no se realizaron cambios en el vehiculo.'],304);
                }
            }
            
            if (!$color || !$cilindraje || !$peso || !$potencia)
            {
                return response()->json(['mensaje' => 'No se pudieron procesar los valores','codigo' => 422],422);
            }
            $vehiculo->color = $color;
            $vehiculo->cilindraje = $cilindraje;
            $vehiculo->peso = $peso;
            $vehiculo->potencia = $potencia;
            $vehiculo->save();
            return response()->json(['mensaje' => 'vehiculo actualizado'],200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $idFabricante, $idVehiculo)
	{   
            $fabricante = Fabricante::find($idFabricante);
            if (!$fabricante)
            {
                return response()->json(['mensaje' => "No se encuentra el fabricante con id=$idFabricante",'codigo' => 404],404);  
            }
            
            $vehiculo = $fabricante->vehiculos()->find($idVehiculo);
            
            if (!$vehiculo)
            {
                return response()->json(['mensaje' => "No se encuentra el vehiculo con id=$idVehiculo asociado al fabricante id=$idFabricante",'codigo' => 404],404);  
            }
            
            $vehiculo->delete();
            
            return response()->json(['mensaje' => 'vehiculo eliminado.'],200);
	}

}
