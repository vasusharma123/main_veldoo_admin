<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSlugToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('slug', 50)->nullable()->default(null)->after('value');
            $table->integer('is_subscribed')->nullable()->default(0)->after('slug');
            $table->dateTime('demo_expiry')->nullable()->default(null)->after('is_subscribed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('is_subscribed');
            $table->dropColumn('demo_expiry');
        });
    }
}
