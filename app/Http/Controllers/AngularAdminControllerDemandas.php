<?php

namespace App\Http\Controllers;

use App\Demanda;
use Illuminate\Http\Request;


class AngularAdminControllerDemandas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function demandas(Request $request)
    {
        
       $data = Demanda::all();
       return response()->success(compact('data'));
    }
   
}