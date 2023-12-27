<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceProviderIdToOtpVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('otp_verifications', function (Blueprint $table) {
            $table->tinyInteger('user_type')->default(null)->nullable()->comment('1 = Customer,2=>Driver')->after('device_type');
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 3')->after('user_type');
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
        Schema::table('otp_verifications', function (Blueprint $table) {
            $table->dropForeign('otp_verifications_service_provider_id_foreign');
            $table->dropIndex('otp_verifications_service_provider_id_index');
            $table->dropColumn('user_type');
            $table->dropColumn('service_provider_id');
        });
    }
}
