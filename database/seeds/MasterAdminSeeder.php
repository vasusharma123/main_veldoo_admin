<?php

use Illuminate\Database\Seeder;

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
            [   'name'  => 'master' , 'first_name' => 'ma', 'last_name' => 'admin', 'country_code' => 91, 'phone' => 65635267, 'country_code_iso' => 'in', 'user_type' => 6,'email' => 'aca.pavlovic@veldoo.com','password'=> '$2y$10$xSf2IjFe1lBCZACwvh06FeH1dP33C.XrkGLnrvHpY5EqwOTrbeiBe', 'status'=>1, 'verify' => 1 ]        ];
        
        DB::table('users')->insert($data);
    }
}
