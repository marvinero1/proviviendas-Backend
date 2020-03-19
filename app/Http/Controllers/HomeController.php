<?php

namespace App\Http\Controllers;

use App\Home;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use File;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
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

        $data = Home::where($columna, 'like', $ff)->orderBy($columna,$order)->paginate($limit); 

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
            'direccion' => 'required|max: 255', 
            'latitud' => 'required',
            'longitud' => 'required',
            'precio' => 'required',
            'estado' => 'required|in:pendiente,aceptado,inactivo',
            'oferta' => 'required|in:venta,alquiler,anticretico',
        ]);

        if ($request->input('id')) {
            $this->validate($request, [
                'imagen' => 'sometimes|required|image'
            ]);
            $home = Home::findOrFail($request->input('id'));
        }else{
            $this->validate($request, [
                'imagen' => 'required|image'
            ]);
        }

        $requestData = $request->all();
        if($request->file('imagen')){
            $file = $request->file('imagen');
            $extension = $file->getClientOriginalExtension();
            $image = Image::make($file)->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $imagen = str_replace(':','-',str_replace(' ','-',Carbon::now()->toDateTimeString().'.'.$extension)); 
            $path  = 'img/Inmuebles';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $img = $path.'/'.$imagen; 
            if($image->save($img)) {
                $requestData['imagen'] = $img;
                if ($request->input('id')) {
                    $archivo_antiguo = $home->imagen;
                    $home->update($requestData);
                    $mensaje = "Actualizado correctamente :3";
                    if (!File::delete($archivo_antiguo)) {
                        $mensaje = "Error al eliminar la imagen";
                    }
                }else{
                    Home::create($requestData);    
                    $mensaje = "Registrado correctamente";
                }
                
            }else{
                $mensaje = "Error al guardar la imagen";
            }
        }else{
            if($request->input('id')){
                $home->update($requestData);
                $mensaje = "Actualizado correctamente";
            }
            
        }
        return response()->success(compact('mensaje'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ciudad  $ciudad
     * @return \Illuminate\Http\Response
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ciudad  $ciudad
     * @return \Illuminate\Http\Response
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ciudad  $ciudad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Home $home)
    {
        $this->validate($request, [
            'titulo' => 'required',
            'direccion' => 'required|max: 255', 
            'latitud' => 'required',
            'longitud' => 'required',
            'precio' => 'required',
            'estado' => 'required|in:pendiente,aceptado,inactivo',
            'oferta' => 'required|in:venta,alquiler,anticretico',
        ]);

        if($request->file('imagen')){
            $file = $request->file('imagen');
            $extension = $file->getClientOriginalExtension();
            $image = Image::make($file);
            $imagen = str_replace(':','-',str_replace(' ','-',Carbon::now()->toDateTimeString().'.'.$extension)); 
            $path  = 'img/inmuebles';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $img = $path.'/'.$imagen; 
            if($image->save($img)) {
                $requestData = $request->all();
                $requestData['imagen'] = $img;
                $home = Home::findOrFail($id);
                $archivo_antiguo = $home->imagen;
                $home->update($requestData);
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
            $home = Home::findOrFail($id);
            $home->update($requestData);
            $mensaje = "Actualizado correctamente :3";
        }

        return response()->success(compact('mensaje'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ciudad  $ciudad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Home $home)
    {
        $home->delete();
        $mensaje = "Eliminado correctamente";
        
        return response()->success(compact('mensaje'));
    }

}
