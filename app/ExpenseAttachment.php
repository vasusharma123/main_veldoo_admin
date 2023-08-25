<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseAttachment extends Model
{
    protected $fillable = ['expense_id', 'url'];

    protected $appends = [
		'image_with_url'
	];

    public function getImageWithUrlAttribute(){
		if(!empty($this->url)){
			return env('URL_PUBLIC').'/'.$this->url;
		}
		return $this->image;
	}
}
