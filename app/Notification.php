<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title', 'description', 'type', 'user_id', 'status', 'additional_data', 'created_at', 'updated_at'
    ];

    protected $appends = ['created_at_unix_timestamp'];

    public static function saveData($inputArr){
        // print_r($inputArr);die;
        return self::create($inputArr);
    }

    public function getCreatedAtUnixTimestampAttribute(){
        return $this->created_at->getTimestamp();
    }

    public function getAdditionalDataAttribute($additional_data){
        if(!empty($additional_data)){
            return json_decode($additional_data);
        }
    }
}
