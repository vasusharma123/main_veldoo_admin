<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DriverChooseCar extends Model
{
    
	 protected $fillable = [
        'user_id','car_id','mileage','logout_mileage','logout',
    ];
	
}
