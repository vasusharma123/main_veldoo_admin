<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key', 'value', 'service_provider_id', 'slug', 'demo_expiry'
    ];

    public function service_provider(){
		return $this->belongsTo(User::class, 'service_provider_id', 'id');
	}
}
