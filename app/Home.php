<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable; 
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Home extends Model implements AuditableContract
{
    use Auditable, SoftDeletes;

   protected $auditStrict = true;

   protected $auditTimestamps = true;

   protected $auditThreshold = 100;

   protected $auditEvents = [
   	'created',
   	'saved',
   	'deleted',
   	'restored',
   	'updated'
   ];

   protected $guarded = [];

   protected $dates = ['deleted_at'];

   public function comentarios(){
      return $this->morphMany('App\Comentario', 'comentariotable');
   }

    public function imagentable()
    {
        return $this->belongsTo('App\Home');
    }

    public function favoritos(){
      return $this->hasMany('App\Favorito');
   }

   public function pagos(){
      return $this->hasMany('App\Favorito');
   }

   public function tips(){
      return $this->belongsTo('App\Tipo');
   }

   public function ciudads(){
      return $this->belongsTo('App\Ciudad');
   }

   public function inmueblesUser(){
      return $this->belongsTo('App\User');
   }

    public function reporte(){
      return $this->hasMany('App\Reporte');
   }
}
