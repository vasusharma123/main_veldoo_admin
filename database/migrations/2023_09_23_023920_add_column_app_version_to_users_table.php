<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAppVersionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('app_version', 25)->default(null)->nullable()->after('device_token');
            $table->string('phone_model', 50)->default(null)->nullable()->after('app_version');
            $table->string('current_timezone', 25)->default(null)->nullable()->after('phone_model');
            $table->string('country_code_iso', 5)->default(null)->nullable()->after('phone');
            $table->string('second_country_code_iso', 5)->default(null)->nullable()->after('second_phone_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('app_version');
            $table->dropColumn('phone_model');
            $table->dropColumn('current_timezone');
            $table->dropColumn('country_code_iso');
            $table->dropColumn('second_country_code_iso');
        });
    }
}
