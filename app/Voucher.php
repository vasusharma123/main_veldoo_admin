<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
       'user_id','title','message','mileage','start_date','end_date','service_provider_id','key','value'
    ];
	
	function user(){
		return $this->hasOne(User::class,'id','user_id');
	}
}
