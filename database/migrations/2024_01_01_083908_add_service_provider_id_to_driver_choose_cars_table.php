<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceProviderIdToDriverChooseCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_choose_cars', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 3')->after('logout');
            $table->index('service_provider_id');
            $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driver_choose_cars', function (Blueprint $table) {
            $table->dropForeign('driver_choose_cars_service_provider_id_foreign');
            $table->dropIndex('driver_choose_cars_service_provider_id_index');
            $table->dropColumn('service_provider_id');
        });
    }
}
