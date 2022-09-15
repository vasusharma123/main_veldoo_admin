<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'year', 'model', 'color', 'vehicle_number_plate', 'vehicle_image', 'category_id'
    ];

    public function carType()
    {
        return $this->belongsTo(Price::class, 'category_id', 'id');
    }

    /**
     * Created By Anil Dogra
     * Created At 09-08-2022
     */
    public function uploadImage($image)
    {
        $fileName   = time() . '.' . $image->getClientOriginalExtension();
        Storage::disk('vehicle')->putFileAs('/', $image, $fileName);
        return $fileName;
    }

    public function last_driver_choosen()
    {
        return $this->hasOne(DriverChooseCar::class, 'car_id', 'id')->orderBy('id', 'Desc');
    }
}
