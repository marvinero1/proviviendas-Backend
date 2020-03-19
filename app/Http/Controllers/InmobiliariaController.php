<?php

namespace App\Http\Controllers;

use App\Inmobiliaria;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use File;

class InmobiliariaController extends Controller
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
        $ff = $filter == '' ? '%%':'%'.$filter.'%';

        $data = Inmobiliaria::where($columna, 'like', $ff)->orderBy($columna,$order)->paginate($limit); 

            foreach ($data as $key => $value) {
            $value->imagen = asset($value->imagen);
            $value->inmobiliarias;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate($request, [

            'inmobiliaria_id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required|max: 255',

        ]);

        if ($request->input('id')) {
            $this->validate($request, [
                'imagen' => 'sometimes|required|image'
            ]);
            $pais = Inmobiliaria::findOrFail($request->input('id'));
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
            $path  = 'img/inmobiliarias';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $img = $path.'/'.$imagen; 
            if($image->save($img)) {
                $requestData['imagen'] = $img;
                if ($request->input('id')) {
                    $archivo_antiguo = $pais->imagen;
                    $pais->update($requestData);
                    $mensaje = "Actualizado correctamente :3";
                    if (!File::delete($archivo_antiguo)) {
                        $mensaje = "Error al eliminar la imagen";
                    }
                }else{
                    Inmobiliaria::create($requestData);    
                    $mensaje = "Registrado correctamente";
                }
                
            }else{
                $mensaje = "Error al guardar la imagen";
            }
        }else{
            if($request->input('id')){
                $pais->update($requestData);
                $mensaje = "Actualizado correctamente";
            }
            
        }
        return response()->success(compact('mensaje'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Inmobiliaria  $inmobiliaria
     * @return \Illuminate\Http\Response
     */
    public function show(Inmobiliaria $inmobiliaria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inmobiliaria  $inmobiliaria
     * @return \Illuminate\Http\Response
     */
    public function edit(Inmobiliaria $inmobiliaria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inmobiliaria  $inmobiliaria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inmobiliaria $inmobiliaria)
    {
        $this->validate($request, [
            
            'inmobiliaria_id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required|max: 255',

        ]);

        if($request->file('imagen')){
            $file = $request->file('imagen');
            $extension = $file->getClientOriginalExtension();
            $image = Image::make($file);
            $imagen = str_replace(':','-',str_replace(' ','-',Carbon::now()->toDateTimeString().'.'.$extension)); 
            $path  = 'img/inmobiliarias';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $img = $path.'/'.$imagen; 
            if($image->save($img)) {
                $requestData = $request->all();
                $requestData['imagen'] = $img;
                $inmobiliaria = Inmobiliaria::findOrFail($id);
                $archivo_antiguo = $inmobiliaria->imagen;
                $inmobiliaria->update($requestData);
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
            $inmobiliaria = Inmobiliaria::findOrFail($id);
            $inmobiliaria->update($requestData);
            $mensaje = "Actualizado correctamente :3";
        }

        return response()->success(compact('mensaje'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inmobiliaria  $inmobiliaria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inmobiliaria $inmobiliaria)
    {
        $inmobiliaria->delete();
        $mensaje = "Eliminado correctamente";
        
        return response()->success(compact('mensaje'));
    }
}
