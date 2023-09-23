<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverStayActiveNotification extends Model
{
    protected $guarded = [];

    public function driver()
    {
        return $this->belongsTo('App\User', 'driver_id', 'id');
    }
}
