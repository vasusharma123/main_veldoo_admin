<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

	class UserVoucher extends Model
	{
	  
		public function service_provider(){
			return $this->belongsTo(User::class, 'service_provider_id', 'id');
		}
	

	}
