<?php

namespace App\Http\Controllers;

use App\Demanda;
use Illuminate\Http\Request;

class DemandaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cliente_id = $request->get('cliente_servicio_id');
        $limit = $request->get('limit');
        //Order
        $columna = $request->get('columna');
        $order = $request->get('order');
        
        $filter = $request->get('filter');
        $ff = $request->get('ff', $filter==''?'%%':'%'.$filter.'%');

        $data = Demanda::where($columna, 'like', $ff)->orderBy($columna,$order)->paginate($limit); 
        
        return response()->success(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required',
            'descripcion' => 'required|max: 255',
            'celular' => 'required',
            'telefono' => 'required',
            'estado' => 'required|in:pendiente,aceptado,inactivo',
            'whatsapp' => 'required',
        ]);
          $requestData = $request->all();

          Demanda::create($requestData);    

          $mensaje = "Registrado correctamente";
          
          return response()->success(compact('mensaje'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Demanda  $demanda
     * @return \Illuminate\Http\Response
     */
    public function show(Demanda $demanda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Demanda  $demanda
     * @return \Illuminate\Http\Response
     */
    public function edit(Demanda $demanda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Demanda  $demanda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Demanda $demanda)
    {
        $this->validate($request, [
            'titulo' => 'required',
            'descripcion' => 'required|max: 255',
            'celular' => 'required',
            'telefono' => 'required',
            'estado' => 'required|in:pendiente,aceptado,inactivo',
            'whatsapp' => 'required',

        ]);
         
            if($requestData = $request->all()) {
                $demanda = Demanda::findOrFail($id);
                $demanda->update($requestData);
                if (File::delete($archivo_antiguo)) {
                    $mensaje = "Actualizado correctamente :3";
                }else{
            
                $mensaje = "Error al guardar los datos :(";
            }
            $requestData = $request->all();
            $demanda = Demanda::findOrFail($id);
            $demanda->update($requestData);
            $mensaje = "Actualizado correctamente :3";
        
    }
        
        return response()->success(compact('mensaje'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Demanda  $demanda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demanda $demanda)
    {
        $demanda->delete();
        $mensaje = "Eliminado correctamente";
        
        return response()->success(compact('mensaje'));
    }
}
