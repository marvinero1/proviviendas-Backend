<?php

namespace App\Http\Controllers;

use App\Reporte;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use File;

class AngularAdminControllerReportes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportes(Request $request)
    {
        
       $data = Reporte::all();
       return response()->success(compact('data'));
    }
   
}