<?php

namespace App\Http\Controllers;

use App\Comentario;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use File;

class AngularAdminControllerComentarios extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comentarios(Request $request)
    {
        
       $data = Comentario::all();
       return response()->success(compact('data'));
    }
   
}