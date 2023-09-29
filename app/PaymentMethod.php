<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PaymentMethod extends Model
{
	protected $fillable = ['name', 'status', 'service_provider_id'];
}
