<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceProviderIdToNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 3');
            $table->index('service_provider_id');
            $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('ride_history', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 3');
            $table->index('service_provider_id');
            // $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('driver_stay_active_notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 3');
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
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign('notifications_service_provider_id_foreign');
            $table->dropIndex('notifications_service_provider_id_index');
            $table->dropColumn('service_provider_id');
        });
        Schema::table('ride_history', function (Blueprint $table) {
            // $table->dropForeign('ride_history_service_provider_id_foreign');
            $table->dropIndex('ride_history_service_provider_id_index');
            $table->dropColumn('service_provider_id');
        });
        Schema::table('driver_stay_active_notifications', function (Blueprint $table) {
            $table->dropForeign('driver_stay_active_notifications_service_provider_id_foreign');
            $table->dropIndex('driver_stay_active_notifications_service_provider_id_index');
            $table->dropColumn('service_provider_id');
        });
    }
}
