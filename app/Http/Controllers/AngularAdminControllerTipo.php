<?php

namespace App\Http\Controllers;

use App\Tipo;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use File;

class AngularAdminControllerTipo extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tipo(Request $request)
    {
        
       $data = Tipo::all();
       return response()->success(compact('data'));
    }
 
}