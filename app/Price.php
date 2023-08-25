<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'car_type',
    'car_image',
    'price_per_km',
    'basic_fee',
    'seating_capacity',
    'alert_time',
    'status'
  ];


  protected $dates = ['deleted_at'];

  public $timestamps = true;
  protected $guarded = [];

  protected $hidden = ["deleted_at"];

  protected $appends = [
		'image_with_url'
	];

  public static function deleteData($id)
  {
    return self::where('id', $id)->delete();
  }
  function carType()
  {
    return $this->hasOne(\App\Category::class, 'id', 'car_type');
  }

  public function cars()
  {
    return $this->hasMany(Vehicle::class, 'category_id', 'id');
  }

  public function getImageWithUrlAttribute(){
		if(!empty($this->car_image)){
			return env('URL_PUBLIC').'/'.$this->car_image;
		}
		return $this->image;
	}

}
