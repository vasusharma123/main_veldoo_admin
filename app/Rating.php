<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Rating extends Model
{
    
	protected $fillable = [
        'ride_id','to_id','from_id','rating','comment'
    ];
	
	
}
