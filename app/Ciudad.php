<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable; 
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Ciudad extends Model implements AuditableContract
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

   public function pais(){
      return $this->belongsTo('App\Pai');
   }

   public function inmuebles(){
      return $this->hasMany('App\Home');
   }

   public function usuario(){
      return $this->hasMany('App\User');
   }

   // public function imagenCiudad(){
   //      return $this->morphOne('App\Ciudad', 'imagenCiudad');
   //  }

}
