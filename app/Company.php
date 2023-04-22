<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','name','address','email','image','status','zip','addresses','password','fcm_token','state','country_code','phone','city','country','created_by','street','logo','background_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
		'image_with_url'
	];

    public function getImageWithUrlAttribute(){
		if(!empty($this->logo)){
			return env('URL_PUBLIC').'/'.$this->logo;
		}
		return $this->logo;
	}

    /**
     * Get the user that owns the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->hasOne(User::class, 'company_id')->where('user_type',4);
    }

}
