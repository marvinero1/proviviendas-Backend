<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Auth\IssueTokenTrait;
use App\Http\Controllers\Controller;
use App\SocialAccount;
use App\User;
use App\Cliente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Laravel\Passport\Client;

class SocialAuthController extends Controller
{

	use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(1);
	}

    public function socialAuth(Request $request){

    	$this->validate($request, [
    		'nombre' => 'required',
            'email' => 'nullable|email',
    		// 'email' => 'required|unique:users,email',
    		'provider' => 'required|in:facebook,google',
    		'provider_user_id' => 'required',
            'rol' => 'required|in:cliente,usuario'
    	]);

    	$socialAccount = SocialAccount::where('provider', $request->provider)->where('provider_user_id', $request->provider_user_id)->first();

    	if($socialAccount){
            $request['rol'] = $socialAccount->user->rol;
    		return $this->issueToken($request, 'social', $request->rol);
    	}

    	$user = User::where('email', $request->email)->first();

    	if($user){
    		$this->addSocialAccountToUser($request, $user);
    	}else{
    		try{
    			$this->createUserAccount($request);
    		}catch(\Exception $e){
    			return response("Ha ocurrido un error, por favor vuelva a intentarlo más tarde", 422);
    		}
    	}

    	return $this->issueToken($request, 'social', $request->rol);
    }

    /**
     * Associate social account to user
     * @param Request $request [description]
     * @param User    $user    [description]
     */
    private function addSocialAccountToUser(Request $request, User $user){

    	$this->validate($request, [
    		'provider' => ['required', Rule::unique('social_accounts')->where(function($query) use ($user) {
    			return $query->where('user_id', $user->id);
    		})],
    		'provider_user_id' => 'required'
    	]);

    	$user->socialAccounts()->create([
			'provider' => $request->provider,
    		'provider_user_id' => $request->provider_user_id
    	]);

    }

    /**
     * Create user accound and Social account
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    private function createUserAccount(Request $request){

    	DB::transaction( function () use ($request){

    		// $user = User::create([
    		// 	'nombre' => $request->nombre,
    		// 	'email' => $request->email,
      //           'tipo' => 'usuario',
    		// ]);


            DB::beginTransaction();
            $tabla = Cliente::create([
                'ciudad_id' => $request->ciudad_id,
                'nombre' => $request->nombre,
                'imagen' => $request->imagen
            ]);
            $user = new User();
            $user->usuario = $request->usuario;
            $user->email = $request->email;
            // $user->password = bcrypt($requestData['password']);
            $user->rol = $request->rol;
            $user->email_verified_at = Carbon::now()->toDateTimeString();

            if($tabla->user()->save($user)){
                // event(new Registered($user));
                DB::commit();
            }
            else{
                DB::rollback();
            }
    		$this->addSocialAccountToUser($request, $user);

    	});

    }
}
