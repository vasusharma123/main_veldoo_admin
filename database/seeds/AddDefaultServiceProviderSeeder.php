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
        DB::table('users')->whereNull('service_provider_id')->whereIn('user_type',[1,2,4,5])->update([
            'service_provider_id' => 1
        ]);

        DB::table('settings')->whereNull('service_provider_id')->update([
            'service_provider_id' => 1
        ]);
        DB::table('vehicles')->whereNull('service_provider_id')->update([
            'service_provider_id' => 1
        ]);
        DB::table('prices')->whereNull('service_provider_id')->update([
            'service_provider_id' => 1
        ]);
        DB::table('rides')->whereNull('service_provider_id')->update([
            'service_provider_id' => 1
        ]);
    }
}
