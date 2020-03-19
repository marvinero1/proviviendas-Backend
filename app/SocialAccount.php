<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAccount extends Model
{
    protected $hidden = [
        // 'deleted_at', 
    ];

	use SoftDeletes;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
