<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $guarded = [];

    public function driver()
    {
        return $this->belongsTo("App\User", "driver_id", "id");
    }

    public function attachments()
    {
        return $this->hasMany(ExpenseAttachment::class, "expense_id", "id");
    }

    public function ride()
    {
        return $this->belongsTo("App\Ride", "ride_id", "id");
    }
}
