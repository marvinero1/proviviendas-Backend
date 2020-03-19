<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use App\User;
use Lcobucci\JWT\Parser;

class LoginController extends Controller
{

    use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(2);
	}

    public function login(Request $request){

    	$this->validate($request, [
            // 'email' => 'required|email|exists:users,email',
            'username' => 'required|exists:users',
    		'password' => 'required'
    	]);
        $user = User::where('username', $request->username)->first();

        $request->email = $user->email;

        if ($user->email_verified_at) {
            return $this->issueToken($request, 'password', $user->rol);
        }else{
            return response(['code' => 403, 'message' => 'Su dirección de correo electrónico no está verificada.'], 403);
        }
    }

    public function refresh(Request $request){
    	$this->validate($request, [
    		'refresh_token' => 'required'
    	]);

    	return $this->issueToken($request, 'refresh_token');

    }

    public function logout(Request $request){

    	// $accessToken = Auth::user()->token();

     //    DB::table('oauth_refresh_tokens')
     //        ->where('access_token_id', $accessToken->id)
     //        ->update(['revoked' => true]);

     //    $accessToken->revoke();
        // Auth::logout();
        // $value = $request->bearerToken();
        // if ($value) {
     
        //     $id = (new Parser())->parse($value)->getHeader('jti');
        //     $token = $request->user()->tokens->fin($id);
        //     $token->revoke();
        //     // $revoked = DB::table('oauth_access_tokens')->where('id', '=', $id)->update(['revoked' => 1]);
        //     // $this->guard()->logout();
        // }
        $value = $request->bearerToken();
        $id= (new Parser())->parse($value)->getHeader('jti');
        $token= $request->user()->tokens->find($id);
        $token->revoke();
        return response(['code' => 200, 'message' => 'Has salido exitosamente'], 200);
    	// return response()->json([], 204);

    }
}
