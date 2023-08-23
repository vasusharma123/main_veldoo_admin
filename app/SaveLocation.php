<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SaveLocation extends Model
{
    
	 protected $fillable = ['lat','user_id','lng','title','type'];
	
}
