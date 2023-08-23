<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminContact extends Model
{
    protected $fillable = [
        'user_id','subject_id','subject_name','description',
    ];
}
