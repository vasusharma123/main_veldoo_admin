<?php

use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [   'id' => 1 , 'plan_name' => 'free',  'plan_type' => 'monthly', 'number_of_driver' => 1, 'organise_rides_and_bookings' => 1 , 'book_rides_with_app' => 1 , 'driver_statement' => 1 , 'client_company_management' => 1, 'export_ride_deails' => 0, 'assign_rides_to_driver' => 0, 'info_notes_to_drivers' => 0, 'promotion_notes_to_client' => 0, 'algorithm_config' => 0, 'online_company_booking' => 0, 'online_guest_booking' => 0, 'send_sms_to_client' => 0, 'charges' => 0, 'currency_type' => 'CHF'],
            [   'id' => 2 , 'plan_name' => 'free',  'plan_type' => 'yearly', 'number_of_driver' => 2 ,'organise_rides_and_bookings' => 1 , 'book_rides_with_app' => 1 , 'driver_statement' => 1 , 'client_company_management' => 1, 'export_ride_deails' => 0, 'assign_rides_to_driver' => 0, 'info_notes_to_drivers' => 0, 'promotion_notes_to_client' => 0, 'algorithm_config' => 0, 'online_company_booking' => 0, 'online_guest_booking' => 0, 'send_sms_to_client' => 0, 'charges' => 0 , 'currency_type' => 'CHF'],
            [   'id' => 3 , 'plan_name' => 'silver',  'plan_type' => 'monthly', 'number_of_driver' => 5 ,'organise_rides_and_bookings' => 1 , 'book_rides_with_app' => 1 , 'driver_statement' => 1 , 'client_company_management' => 1, 'export_ride_deails' => 1, 'assign_rides_to_driver' => 1, 'info_notes_to_drivers' => 1, 'promotion_notes_to_client' => 1, 'algorithm_config' => 0, 'online_company_booking' => 0, 'online_guest_booking' => 0, 'send_sms_to_client' => 0, 'charges' => 90 , 'currency_type' => 'CHF'],
            [   'id' => 4 , 'plan_name' => 'silver',  'plan_type' => 'yearly', 'number_of_driver' => 5 ,'organise_rides_and_bookings' => 1 , 'book_rides_with_app' => 1 , 'driver_statement' => 1 , 'client_company_management' => 1, 'export_ride_deails' => 1, 'assign_rides_to_driver' => 1, 'info_notes_to_drivers' => 1, 'promotion_notes_to_client' => 1, 'algorithm_config' => 0, 'online_company_booking' => 0, 'online_guest_booking' => 0, 'send_sms_to_client' => 0, 'charges' => 1080 , 'currency_type' => 'CHF'],
            [   'id' => 5 , 'plan_name' => 'gold',  'plan_type' => 'monthly', 'number_of_driver' => 10 , 'organise_rides_and_bookings' => 1 , 'book_rides_with_app' => 1 , 'driver_statement' => 1 , 'client_company_management' => 1, 'export_ride_deails' => 1, 'assign_rides_to_driver' => 1, 'info_notes_to_drivers' => 1, 'promotion_notes_to_client' => 1, 'algorithm_config' => 1, 'online_company_booking' => 1, 'online_guest_booking' => 1, 'send_sms_to_client' => 1, 'charges' => 180 , 'currency_type' => 'CHF'],
            [   'id' => 6 , 'plan_name' => 'gold',  'plan_type' => 'yearly', 'number_of_driver' => 10, 'organise_rides_and_bookings' => 1 , 'book_rides_with_app' => 1 , 'driver_statement' => 1 , 'client_company_management' => 1, 'export_ride_deails' => 1, 'assign_rides_to_driver' => 1, 'info_notes_to_drivers' => 1, 'promotion_notes_to_client' => 1, 'algorithm_config' => 1, 'online_company_booking' => 1, 'online_guest_booking' => 1, 'send_sms_to_client' => 1, 'charges' => 2160 , 'currency_type' => 'CHF'],

        ];

        DB::table('plans')->insert($data);
    }
}
