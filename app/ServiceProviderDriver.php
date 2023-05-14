<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ServiceProviderDriver extends Model
{
    protected $fillable = [
        'driver_id','service_provider_id'
    ];

    /**
     * Get the user associated with the ServiceProviderDriver
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
