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
        'year','model','color','vehicle_number_plate','vehicle_image','category_id'
    ];
	

public function carType()
    {
       return $this->hasOne(Price::class,'id','category_id');
    }

    /**
    * Created By Anil Dogra
     * Created At 09-08-2022
     * @param null
     * @return array of formated save product
     */
	public function uploadImage($image)
    {
		
            
        $fileName   = time().'.'.$image->getClientOriginalExtension();            
        Storage::disk('vehicle')->putFileAs('/', $image,$fileName);
        return $fileName;
    }
}
