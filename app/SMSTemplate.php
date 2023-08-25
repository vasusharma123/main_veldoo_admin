<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SMSTemplate extends Model
{   
    protected $guarded = [];
    protected $table = "sms_templates";
}
