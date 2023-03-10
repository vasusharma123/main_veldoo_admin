<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDeviceTypeToOtpVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('otp_verifications', function (Blueprint $table) {
            $table->string('device_type', 20)->nullable()->default(null)->after('expiry')->comment('android,ios,web');
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
            $table->dropColumn('device_type');
        });
    }
}
