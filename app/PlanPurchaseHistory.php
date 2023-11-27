<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanPurchaseHistory extends Model
{
    protected $table = 'plan_purchase_history';

    protected $fillable = [
        'user_id ', 'plan_id ', 'purchase_date', 'expire_at', 'currency','paid_amount','status'
    ];
}
