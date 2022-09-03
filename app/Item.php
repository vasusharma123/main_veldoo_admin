<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model{
	
    protected $fillable = [
        'name','price','user_id','cat_id','cat_name','qty','image',
    ];
}
