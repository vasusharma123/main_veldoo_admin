<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnThemeColorToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('logo')->nullable()->default(null)->after('is_test_plan_updated');
            $table->string('background_image')->nullable()->default(null)->after('logo');
            $table->string('header_color',50)->nullable()->default(null)->after('background_image');
            $table->string('header_font_family',50)->nullable()->default(null)->after('header_color');
            $table->string('header_font_color',50)->nullable()->default(null)->after('header_font_family');
            $table->integer('header_font_size')->nullable()->default(null)->after('header_font_color');
            $table->string('input_color',50)->nullable()->default(null)->after('header_font_size');
            $table->string('input_font_family',50)->nullable()->default(null)->after('input_color');
            $table->string('input_font_color',50)->nullable()->default(null)->after('input_font_family');
            $table->integer('input_font_size')->nullable()->default(null)->after('input_font_color');
            $table->string('ride_color',50)->nullable()->default(null)->after('input_font_size');
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
            $table->dropColumn('logo');
            $table->dropColumn('background_image');
            $table->dropColumn('header_color');
            $table->dropColumn('header_font_family');
            $table->dropColumn('header_font_color');
            $table->dropColumn('header_font_size');
            $table->dropColumn('input_color');
            $table->dropColumn('input_font_family');
            $table->dropColumn('input_font_color');
            $table->dropColumn('input_font_size');
            $table->dropColumn('ride_color');
        });
    }
}
