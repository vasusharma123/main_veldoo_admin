<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RideHistory extends Model
{
    	/**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'ride_id',
        'driver_id',
        'status',
        'created_at',
        'updated_at'
    ];
	
	protected $table='ride_history';

	/**
     * Created By Anil Dogra
     * Created At 28-07-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object after send reset password token
     * This function use to list of save data
     */
	
	public function saveData($inputArr){
		// print_r($inputArr);die;
		return self::create($inputArr);
	}

	/**
     * Created By Anil Dogra
     * Created At 28-07-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object after send reset password token
     * This function use to get Ride Cancel Data
     */

	public static function getRideCancelData($id,$status){
		// print_r($inputArr);die;
		return self::where('ride_id',$id)->where('status',$status)->pluck('driver_id')->all();;
	}
    /**
     * Created By Anil Dogra
     * Created At 28-07-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object after send reset password token
     * This function use to get Ride history Data
     */

    public static function getRideHistoryData($id){
        // print_r($inputArr);die;
        return self::where('ride_id',$id)->whereIn('status',['0','1','2'])->pluck('driver_id')->all();
    }

}
