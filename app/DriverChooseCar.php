<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DriverChooseCar extends Model
{

    protected $fillable = [
        'user_id', 'car_id', 'mileage', 'logout_mileage', 'logout', 'service_provider_id'
    ];
	
    
    public function driver()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'car_id', 'id');
    }
}
