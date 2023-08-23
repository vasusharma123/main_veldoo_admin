<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Promotion extends Model
{
    
	protected $fillable = [
        'pickup_address','dest_address','user_id','promotion','type'
    ];
	
}
