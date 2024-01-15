<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Refer extends Model
{
    
    protected $table = 'refer';	
    protected $fillable = ['user_id','service_provider_id','refer_code'];
}
