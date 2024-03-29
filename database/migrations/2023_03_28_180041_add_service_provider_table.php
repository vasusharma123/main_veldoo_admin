<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->bigInteger('service_provider_id')->nullable();
        });
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->bigInteger('service_provider_id')->nullable();
        });
        Schema::table('sms_templates', function (Blueprint $table) {
            $table->bigInteger('service_provider_id')->nullable();
            $table->string('unique_key',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->dropColumn('service_provider_id');
        });
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('service_provider_id');
        });
        Schema::table('sms_templates', function (Blueprint $table) {
            $table->dropColumn('service_provider_id');
            $table->dropColumn('unique_key');
        });
    }
}
