<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AdminControl extends Model
{
    
protected $fillable = ['driver_cancel_time','max_rides_cancelled','emergency_contact','status','minimum_price_per_km','rush_hours_price'];
	
//protected $table="";
}
