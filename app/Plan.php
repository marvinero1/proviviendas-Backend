<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable; 
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Plan extends Model implements AuditableContract
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

   public function pagos(){
      return $this->hasMany('App\Pago');
   }
}
