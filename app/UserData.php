<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $fillable = [
        'user_id','meta_key','meta_value','phone_numbers','email','addresses','favourite_address','driver_id','image','first_name','last_name'
    ];
	
	/* public function user()
    {
        return $this->belongsTo(User::class);
    } */
}
