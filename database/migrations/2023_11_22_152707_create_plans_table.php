<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plan_name');
            $table->string('plan_type');
            $table->string('number_of_driver');
            $table->boolean('organise_rides_and_bookings')->default(false);
            $table->boolean('book_rides_with_app')->default(false); 
            $table->boolean('driver_statement')->default(false);
            $table->boolean('client_company_management')->default(false);
            $table->boolean('export_ride_deails')->default(false);
            $table->boolean('assign_rides_to_driver')->default(false);
            $table->boolean('info_notes_to_drivers')->default(false);
            $table->boolean('promotion_notes_to_client')->default(false);
            $table->boolean('algorithm_config')->default(false);
            $table->boolean('online_company_booking')->default(false);
            $table->boolean('online_guest_booking')->default(false);
            $table->boolean('send_sms_to_client')->default(false);
            $table->decimal('charges', 10, 2);
            $table->string('currency_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
