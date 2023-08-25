<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    protected $fillable = [
        'name','status'
    ];
	public function itemListfresh(){
		return $this->hasMany(Item::class,'cat_id','id');
    }
	public function itemList(){
		return $this->hasMany(Item::class,'cat_id','id')->where(['user_id' => Auth::user()->id]);
    }
	/* public function catitemList($driver_id){
		return $this->hasMany(Item::class,'cat_id','id')->where(['user_id' => $driver_id]);
    }
	public function driverdetail($driver_id){
		return $this->belongsTo(User::class)->where('id', $driver_id);
    } */
	public function scopeOfSearch($query, $q)
	{
		if ( $q ) {
			$query->where('name', 'LIKE', '%' . $q . '%');
		}

		return $query;
	}

	public function scopeOfSort($query, $sort = [])
	{
		if ( ! empty($sort) ) {
			foreach ( $sort as $column => $direction ) {
				$query->orderBy($column, $direction);
			}
		} 
		else {
			$query->orderBy('id'); 
		}

		return $query;
	}
	
    public function total()
    {
    	return $this->hasMany(UserCategory::class);
    }
    public function likes()
    {
        return $this->hasOne(UserCategory::class);
    } 
	public function cars()
    {
      return $this->hasMany(Vehicle::class,'category_id','id');
    }
}
