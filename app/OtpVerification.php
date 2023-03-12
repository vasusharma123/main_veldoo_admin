<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = [
        'phone', 'expiry', 'otp', 'country_code', 'device_type'
    ];
}
