<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;
use Carbon\Carbon;
use File;

class UserController extends Controller
{   

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
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

        $data = User::where($columna, 'like', $ff)->orderBy($columna,$order)->paginate($limit); 

            foreach ($data as $key => $value) {
            $value->imagen = asset($value->imagen);
            $value->imagen;
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
            'nombre' => 'required',
            'rol' => 'required|in:root,administrador,usuario,inmobiliaria',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|bcrypt, min: 5',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        if ($request->input('id')) {
            $this->validate($request, [
                'imagen' => 'sometimes|required|image'
            ]);
            $pais = User::findOrFail($request->input('id'));
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
            $path  = 'img/usuarios';
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

                   // User::create($requestData);  
                    DB::beginTransaction();
                    // $tabla = Usuario::create([
                    //     'nombre' => $requestData['nombre'],
                    // ]);
                    $c = new User();
                    $c->username = $requestData['username'];
                    $c->password = bcrypt($requestData['password']);
                    $c->nombre = $requestData['nombre'];
                    $c->email = $requestData['email'];
                    $c->telefono = $requestData['telefono'];
                    $c->celular = $requestData['celular'];
                    $c->whatsapp = $requestData['whatsapp'];
                    $c->ciudad_id = $requestData['ciudad_id'];
                    $c->imagen = $requestData['imagen'];
                    $c->fecha_nacimiento = $requestData['fecha_nacimiento'];
                    $c->sexo =  $requestData['sexo'];
                    $c->rol = $requestData['rol'];
                    
                    if($c->save()){
                        DB::commit();
                    }
                    else{
                        DB::rollback();
                    }
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
     * @param  \App\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'rol' => 'required|in:root,administrador,usuario,inmobiliaria',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|bcrypt, min: 5',
        ]);

        if($request->file('imagen')){
            $file = $request->file('imagen');
            $extension = $file->getClientOriginalExtension();
            $image = Image::make($file);
            $imagen = str_replace(':','-',str_replace(' ','-',Carbon::now()->toDateTimeString().'.'.$extension)); 
            $path  = 'img/users';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $img = $path.'/'.$imagen; 
            if($image->save($img)) {
                $requestData = $request->all();
                $requestData['imagen'] = $img;
                $user = User::findOrFail($id);
                $archivo_antiguo = $user->imagen;
                $user->update($requestData);
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
            $user = User::findOrFail($id);
            $user->update($requestData);
            $mensaje = "Actualizado correctamente :3";
        }

        return response()->success(compact('mensaje'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $User)
    {
        $User->delete();
        $mensaje = "Eliminado correctamente";
        
        return response()->success(compact('mensaje'));
    }
}
