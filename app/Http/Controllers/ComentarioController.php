<?php

namespace App\Http\Controllers;

use App\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
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
        $data = Comentario::where($columna, 'like', $ff)->orderBy($columna,$order)->paginate($limit);   
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
            'comentariotetable_id' => 'required',
            'comentariotable_type' => 'required',
            'comentario' => 'required',
            
        ]);
          $requestData = $request->all();

          Comentario::create($requestData);    

          $mensaje = "Registrado correctamente";
          
          return response()->success(compact('mensaje'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function show(Comentario $comentario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function edit(Comentario $comentario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        
        $this->validate($request, [
            'comentariotetable_id' => 'required',
            'comentariotable_type' => 'required',
            'comentario' => 'required',
        ]);

            $comentario = Comentario::find($id);
            $requestData = $request->all();
            
            $comentario->update($requestData);
            $mensaje = "Actualizado correctamente :3";
                
            return response()->success(compact('mensaje'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comentario $comentario)
    {
        $comentario->delete();
        $mensaje = "Eliminado correctamente";
        
        return response()->success(compact('mensaje'));
    }
}
