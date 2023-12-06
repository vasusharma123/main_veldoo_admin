<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name'  => 'master', 'first_name' => 'ma', 'last_name' => 'admin', 'country_code' => 41, 'phone' => 65635267, 'country_code_iso' => 'ch', 'user_type' => 6, 'email' => 'aca.pavlovic@veldoo.com', 'password' => Hash::make('xT@J,G!<?%]z'), 'status' => 1, 'verify' => 1]
        ];

        User::insert($data);
    }
}
