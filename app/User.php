<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;


class User extends Authenticatable
{   
    
    use  HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public static function resolveId()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }

    //estrictas auditorías
    protected $auditStrict = true;
    //auditarse las marcas de tiempo
    protected $auditTimestamps = true;
    //Número de registros de auditoría
    protected $auditThreshold = 100;
    //eventos auditables
    protected $auditableEvents = [
        'created', 
        'saved', 
        'deleted', 
        'updated'
    ];
    public function findForPassport($identifier) {
        return $this->orWhere('email', $identifier)->orWhere('username', $identifier)->first();
    }

    protected $guarded = [];

    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $dates = ['deleted_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function socialAccounts(){
        return $this->hasMany('App\SocialAccount');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\Auth\VerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
       $this->notify(new \App\Notifications\Auth\ResetPassword($token));
    }

    public function comentarios(){
      return $this->belongsTo ('App\Comentario');
   }

   public function favoritos(){
      return $this->hasMany('App\Favorito');
   }

   public function pagos(){
      return $this->hasMany('App\Pago');
   }

   public function demanda(){
      return $this->hasMany('App\Demanda');
   }

   public function reportes(){
      return $this->hasMany('App\Reporte');
   }

   public function inmuebles(){
      return $this->hasMany('App\Home');
   }

   public function inmobiliarias(){
      return $this->hasMany('App\Inmobiliaria');
   }

   public function ciudad(){
      return $this->belongsTo('App\Ciudad');
   }
}
