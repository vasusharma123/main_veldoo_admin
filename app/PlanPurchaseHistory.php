<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class PlanPurchaseHistory extends Model
{
    protected $table = 'plan_purchase_history';

    protected $fillable = [
        'user_id ', 'plan_id ', 'purchase_date', 'expire_at', 'currency','paid_amount','status'
    ];

    protected $appends = [
		'encrypted_id'
	];

    public function service_provider()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function getEncryptedIdAttribute()
    {
       // dd('sfs');
        return Crypt::encrypt($this->attributes['id']);
    }

}
