<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class RegisterController extends Controller
{
    use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(1);
	}

    public function register(Request $request){

    	$this->validate($request, [
    		'nombre' => 'required',
            'celular' => 'required',
            'usuario' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'tipo'  =>  'required|in:root,administrador,empleado,cliente'
    	]);

    	$user = User::create([
    		'nombre' => request('nombre'),
            'ci' => request('ci'),
            'telefono' => request('telefono'),
            'celular' => request('celular'),
            'usuario' => request('usuario'),
    		'email' => request('email'),
    		'password' => bcrypt(request('password')),
            'tipo' => request('tipo'),

    	]);

    	return $this->issueToken($request, 'password');

    }
}
