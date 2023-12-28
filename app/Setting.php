<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key', 'value', 'service_provider_id', 'slug', 'demo_expiry', 'logo', 'background_image', 'header_color', 'header_font_family', 'header_font_color', 'header_font_size', 'input_color', 'input_font_family', 'input_font_color', 'input_font_size', 'ride_color'
    ];

    public function service_provider(){
		return $this->belongsTo(User::class, 'service_provider_id', 'id');
	}
}
