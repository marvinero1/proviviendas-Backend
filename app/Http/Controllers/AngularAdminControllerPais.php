<?php

namespace App\Http\Controllers;

use App\Pai;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use File;

class AngularAdminControllerPais extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paises(Request $request)
    {
        
       $data = Pai::all();
       return response()->success(compact('data'));
    }
   
}