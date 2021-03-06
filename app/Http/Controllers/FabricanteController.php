<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Fabricante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FabricanteController extends Controller {

        public function __construct() {
            $this->middleware('auth.basic.once', ['only' => ['store','update','destroy']]);
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
                //DURANTE 15 SEG CACHEA LA RESPUESTA PARA EVITAR SOBRECARGA EN LA BD
                $fabricantes = Cache::remember('fabricantes', 15/60, function()
                {
                    return Fabricante::simplePaginate(15);
                });
		return response()->json(['siguiente' => $fabricantes->nextPageUrl(), 'anterior' => $fabricantes->previousPageUrl(), 'datos' => $fabricantes->items()],200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
            if (!$request->input('nombre') || !$request->input('telefono'))
            {
                return response()->json(['mensaje' => 'No se pudieron procesar los valores','codigo' => 422],422);
            }
            Fabricante::create($request->all());
            return response()->json(['mensaje' => 'Fabricante insertado'],200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
                $fabricante = Fabricante::find($id);
                if (!$fabricante)
                    {
                        return response()->json(['mensaje' => "No se encuentra el fabricante con id=$id",'codigo' => 404],404); 
                    }
		return response()->json(['datos' => $fabricante],200);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request  $request , $id)
	{
            $metodo = $request->method();
            $fabricante = Fabricante::find($id);
            if (!$fabricante)
            {
                return response()->json(['mensaje' => "No se encuentra el fabricante con id=$id",'codigo' => 404],404);  
            }
            $nombre = $request->input('nombre');
            $telefono = $request->input('telefono');
            if ($metodo === 'PATCH')
            {   
                
                if ($nombre!=null && $nombre!=''){
                $fabricante->nombre = $nombre;}
                
                
                if ($telefono!=null && $telefono!=''){
                $fabricante->telefono = $telefono;}
                
                $fabricante->save();
                return response()->json(['mensaje' => 'fabricante actualizado'],200);
            }
            
            if (!$nombre || !$telefono)
            {
                return response()->json(['mensaje' => 'No se pudieron procesar los valores','codigo' => 422],422);
            }
            $fabricante->nombre = $nombre;
            $fabricante->telefono = $telefono;
            $fabricante->save();
            return response()->json(['mensaje' => 'fabricante actualizado'],200);
            
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            $fabricante = Fabricante::find($id);
            if (!$fabricante)
            {
                return response()->json(['mensaje' => "No se encuentra el fabricante con id=$id",'codigo' => 404],404);  
            }
            
            $vehiculos = $fabricante->vehiculos;
            
            if (sizeof($vehiculos)>0)
            {
                return response()->json(['mensaje' => "El fabricante con id=$id tiene vehiculos asiciados, eliminar primero sus vehiculos",'codigo' => 409],409);
            }
            $fabricante->delete();
            
            return response()->json(['mensaje' => 'fabricante eliminado'],200);
	}

}
