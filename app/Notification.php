<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title', 'description', 'type', 'user_id', 'status', 'additional_data', 'created_at', 'updated_at'
    ];

    public static function saveData($inputArr){
        // print_r($inputArr);die;
        return self::create($inputArr);
    }

   /*  protected $fillable = [
        'user_id','user_id_op','operation_id','title','description','type','other','status','timestamp'
    ];



    protected $casts = [
        'user_id' => 'integer',
        'user_id_op' => 'integer',
    ];
	
    public function getUserIdAttribute($value)
	{
		return (int)$value;
	}
    public function getUserIdOpAttribute($value)
	{
		return (int)$value;
	} */

    public function getAdditionalDataAttribute($additional_data){
        if(!empty($additional_data)){
            return json_decode($additional_data);
        }
    }
}
