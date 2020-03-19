<?php

namespace App\Http\Controllers;

use App\Caracteristica;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use File;

class CaracteristicaController extends Controller
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

        $data = Caracteristica::where($columna, 'like', $ff)->orderBy($columna,'asc',$order)->paginate($limit); 

            foreach ($data as $key => $value) {
            $value->imagen = asset($value->imagen);
            $value->pais;
        }   
        
        return response()->success(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'nombre' => 'required',
            'descripcion' => 'required',
            'tipo' => 'required|in:number,boolean',
        ]);

        if ($request->input('id')) {
            $this->validate($request, [
                'imagen' => 'sometimes|required|image'
            ]);
            $caracteristica = Caracteristica::findOrFail($request->input('id'));
        }else{
            $this->validate($request, [
                'imagen' => 'required|image'
            ]);
        }

        $requestData = $request->all();
        if($request->file('imagen')){
            $file = $request->file('imagen');
            $extension = $file->getClientOriginalExtension();
            $image = Image::make($file);
            $imagen = str_replace(':','-',str_replace(' ','-',Carbon::now()->toDateTimeString().'.'.$extension)); 
            $path  = 'img/caracteristica';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $img = $path.'/'.$imagen; 
            if($image->save($img)) {
                $requestData['imagen'] = $img;
                if ($request->input('id')) {
                    $archivo_antiguo = $caracteristica->imagen;
                    $caracteristica->update($requestData);
                    $mensaje = "Actualizado correctamente :3";
                    if (!File::delete($archivo_antiguo)) {
                        $mensaje = "Error al eliminar la imagen";
                    }
                }else{
                    Caracteristica::create($requestData);    
                    $mensaje = "Registrado correctamente";
                }
                
            }else{
                $mensaje = "Error al guardar la imagen";
            }
        }else{
            if($request->input('id')){
                $caracteristica->update($requestData);
                $mensaje = "Actualizado correctamente";
            }
            
        }
        return response()->success(compact('mensaje'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Caracteristica  $caracteristica
     * @return \Illuminate\Http\Response
     */
    public function show(Caracteristica $caracteristica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Caracteristica  $caracteristica
     * @return \Illuminate\Http\Response
     */
    public function edit(Caracteristica $caracteristica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Caracteristica  $caracteristica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caracteristica $caracteristica)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'descripcion' => 'required',
            'tipo' => 'required|in:number,boolean',

        ]);

        if($request->file('imagen')){
            $file = $request->file('imagen');
            $extension = $file->getClientOriginalExtension();
            $image = Image::make($file);
            $imagen = str_replace(':','-',str_replace(' ','-',Carbon::now()->toDateTimeString().'.'.$extension)); 
            $path  = 'img/ciudad';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $img = $path.'/'.$imagen; 
            if($image->save($img)) {
                $requestData = $request->all();
                $requestData['imagen'] = $img;
                $ciudad = Ciudad::findOrFail($id);
                $archivo_antiguo = $ciudad->imagen;
                $ciudad->update($requestData);
                if (File::delete($archivo_antiguo)) {
                    $mensaje = "Actualizado correctamente :3";
                }else{
                    $mensaje = "Actualizado. error al eliminar la imagen";
                }
            }else{
                $mensaje = "Error al guardar la imagen";
            }
        }else{

            $requestData = $request->all();
            $ciudad = Ciudad::findOrFail($id);
            $ciudad->update($requestData);
            $mensaje = "Actualizado correctamente :3";
        }

        return response()->success(compact('mensaje'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Caracteristica  $caracteristica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caracteristica $caracteristica)
    {
        $caracteristica->delete();
        $mensaje = "Eliminado correctamente";
        
        return response()->success(compact('mensaje'));
    }
}
