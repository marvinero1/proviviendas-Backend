<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;


class AngularAdminControllerPlanes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function plan(Request $request)
    {
        
       $data = Plan::all();
       return response()->success(compact('data'));
    }
 
}