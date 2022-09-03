<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PaymentManagement extends Model
{
    
protected $fillable = ['fee','status'];
	
protected $table="payment_managements";
}
