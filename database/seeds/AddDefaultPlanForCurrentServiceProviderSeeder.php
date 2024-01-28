<?php

use App\PlanPurchaseHistory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AddDefaultPlanForCurrentServiceProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = PlanPurchaseHistory::firstOrNew(['user_id' => 1, 'plan_id' => 5]);
        $obj->purchase_date = Carbon::now();
        $obj->expire_at = Carbon::now()->addYears(10);
        $obj->license_type = 'Yearly';
        $obj->plan_status = 'active';
        $obj->save();
    }
}
