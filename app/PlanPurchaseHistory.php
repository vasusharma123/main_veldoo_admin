<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanPurchaseHistory extends Model
{
    protected $table = 'plan_purchase_history';

    protected $fillable = [
        'user_id ', 'plan_id ', 'purchase_date', 'expire_at', 'currency','paid_amount','status'
    ];

    public function service_provider()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

}
