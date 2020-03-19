<?php

namespace App\Http\Controllers;

use App\Ciudad;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use File;

class AngularAdminControllerCiudad extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ciudad(Request $request)
    {
        
       $data = Ciudad::all();
       return response()->success(compact('data'));
    }
 
}