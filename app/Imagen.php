<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
class Imagen extends Model implements AuditableContract
{
    use Auditable, SoftDeletes;

    //estrictas auditorías
    protected $auditStrict = true;
    //auditarse las marcas de tiempo
    protected $auditTimestamps = true;
    //Número de registros de auditoría
    protected $auditThreshold = 100;
    //eventos auditables
    protected $auditEvents = [
        'created',
        'saved',
        'deleted',
        'restored',
        'updated'
    ];
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    
    public function imagenHome()
    {
        return $this->hasMany('App\Home');

    }

    public function imagenCiudad(){
        return $this.morphoTo('App\Ciudad');
    }

}
