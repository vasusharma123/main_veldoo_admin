<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Salary extends Model
{
    
    protected $table = 'salaries';	
    protected $fillable = ['type','rate','driver_id','service_provider_id'];
}
