<?php

namespace App\Http\Controllers;

use App\Formapago;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AngularAdminControllerFormaPagos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Formapagos(Request $request)
    {
        
       $data = Formapago::all();
       return response()->success(compact('data'));
    }
 
}