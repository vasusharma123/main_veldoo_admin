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
    }
}
