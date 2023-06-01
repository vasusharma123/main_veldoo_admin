<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesInValuesToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $jayParsedAry = [
            "admin_logo" => "setting/admin-logo.png", 
            "radius" => "50", 
            "site_name" => "Veldoo", 
            "first_x_free_users" => "1", 
            "admin_free_subscription_days" => "1", 
            "copyright" => "Veldoo", 
            "admin_primary_color" => "#000000", 
            "ad_interval" => "2", 
            "topic_title_limit" => "2", 
            "admin_background" => "setting//admin-background.png", 
            "admin_favicon" => "setting/admin-favicon.png", 
            "admin_sidebar_logo" => "setting/admin-sidebar-logo.png", 
            "_token" => "yaTGNl82IrsdGegq8xxj90HJhiCAIbLLaOh7atBE", 
            "facebook_link" => "facebook1", 
            "twitter_link" => "twitter2", 
            "instagram_link" => "Instagram3", 
            "paypal_email" => "test@gmail.com", 
            "admin_commission" => "21", 
            "base_delivery_price" => "21", 
            "base_delivery_distance" => "21", 
            "tax" => "21", 
            "credit_card_fee" => "21", 
            "stripe_mode" => "test1", 
            "stripe_test_secret_key" => "23131231121312", 
            "stripe_test_publish_key" => "2123131213", 
            "ride_type" => "1", 
            "pickup_address" => "sec 10 chandigarh", 
            "dest_address" => "sec 12 chandigarh", 
            "additional_notes" => "test", 
            "notification" => 0, 
            "number_of_drivers_get_notification" => "1", 
            "currency_symbol" => "CHF", 
            "currency_name" => "Franken", 
            "interval_time" => "1", 
            "driver_requests" => "3", 
            "waiting_time" => "30", 
            "pickup_distance" => "1", 
            "join_radius" => "5", 
            "first_request_send" => "2", 
            "driver_idle_time" => "60", 
            "current_ride_distance_addition" => "10", 
            "waiting_ride_distance_addition" => "15", 
            "temporary_phone_number_users" => "40", 
            "temporary_last_name_users" => "20", 
            "driver_count_to_display" => "3", 
            "want_send_sms_to_user_when_ride_accepted_by_driver" => "0", 
            "want_send_sms_to_user_when_driver_reached_to_pickup_point" => "0", 
            "want_send_sms_to_user_when_driver_cancelled_the_ride" => "0" 
        ]; 
        \DB::table('settings')->where('key', '_configuration')->update(['value' => json_encode($jayParsedAry)]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $jayParsedAry = [
            "admin_logo" => "setting/admin-logo.png", 
            "radius" => "50", 
            "site_name" => "Veldoo", 
            "first_x_free_users" => "1", 
            "admin_free_subscription_days" => "1", 
            "copyright" => "Veldoo", 
            "admin_primary_color" => "#000000", 
            "ad_interval" => "2", 
            "topic_title_limit" => "2", 
            "admin_background" => "setting//admin-background.png", 
            "admin_favicon" => "setting/admin-favicon.png", 
            "admin_sidebar_logo" => "setting/admin-sidebar-logo.png", 
            "_token" => "yaTGNl82IrsdGegq8xxj90HJhiCAIbLLaOh7atBE", 
            "facebook_link" => "facebook1", 
            "twitter_link" => "twitter2", 
            "instagram_link" => "Instagram3", 
            "paypal_email" => "test@gmail.com", 
            "admin_commission" => "21", 
            "base_delivery_price" => "21", 
            "base_delivery_distance" => "21", 
            "tax" => "21", 
            "credit_card_fee" => "21", 
            "stripe_mode" => "test1", 
            "stripe_test_secret_key" => "23131231121312", 
            "stripe_test_publish_key" => "2123131213", 
            "ride_type" => "1", 
            "pickup_address" => "sec 10 chandigarh", 
            "dest_address" => "sec 12 chandigarh", 
            "additional_notes" => "test", 
            "notification" => 0, 
            "number_of_drivers_get_notification" => "1", 
            "currency_symbol" => "CHF", 
            "currency_name" => "Franken", 
            "interval_time" => "1", 
            "driver_requests" => "3", 
            "waiting_time" => "30", 
            "pickup_distance" => "1", 
            "join_radius" => "5", 
            "first_request_send" => "2", 
            "driver_idle_time" => "60", 
            "current_ride_distance_addition" => "10", 
            "waiting_ride_distance_addition" => "15", 
            "temporary_phone_number_users" => "40", 
            "temporary_last_name_users" => "20", 
            "driver_count_to_display" => "3" 
        ]; 
        \DB::table('settings')->where('key', '_configuration')->update(['value' => json_encode($jayParsedAry)]);
    }
}
