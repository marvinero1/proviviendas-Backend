<?php

namespace App\Http\Controllers;

use App\Home;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use File;

class AngularAdminControllerInmueble extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inmuebles(Request $request)
    {
        
       $data = Home::all();
       return response()->success(compact('data'));
    }
   
}