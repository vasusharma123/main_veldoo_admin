<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddDefaultServiceProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->whereIn('user_type',[2,4,5])
        ->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })
        ->update([
            'service_provider_id' => 1
        ]);

        DB::table('settings')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);
        DB::table('vehicles')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);
        DB::table('prices')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);
        DB::table('rides')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);

        DB::table('payment_methods')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);

        DB::table('sms_templates')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);

        DB::table('sms_templates')->where(['service_provider_id'=>1,'id'=>1])->update([
            'unique_key' => "send_otp_create_booking"
        ]);

        DB::table('sms_templates')->where(['service_provider_id'=>1,'id'=>2])->update([
            'unique_key' => "send_booking_details_after_create_booking"
        ]);

        DB::table('sms_templates')->where(['service_provider_id'=>1,'id'=>3])->update([
            'unique_key' => "send_otp_for_my_bookings"
        ]);

        DB::table('sms_templates')->where(['service_provider_id'=>1,'id'=>4])->update([
            'unique_key' => "send_otp_before_ride_edit"
        ]);

        DB::table('sms_templates')->where(['service_provider_id'=>1,'id'=>5])->update([
            'unique_key' => "send_booking_details_after_edit_booking"
        ]);

        DB::table('pages')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);

        DB::table('vouchers')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);

        DB::table('promotions')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);

        DB::table('expense_types')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);

        DB::table('expenses')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);

        DB::table('notifications')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);

        DB::table('ride_history')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);

        DB::table('user_vouchers')->where(function($query){
            $query->where(['service_provider_id' => ''])
            ->orWhereNull('service_provider_id');
        })->update([
            'service_provider_id' => 1
        ]);
    }
}
