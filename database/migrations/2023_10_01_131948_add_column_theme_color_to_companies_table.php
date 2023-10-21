<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnThemeColorToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('header_color',50)->nullable()->default(null);
            $table->string('header_font_family',50)->nullable()->default(null);
            $table->string('header_font_color',50)->nullable()->default(null);
            $table->string('header_font_size',50)->nullable()->default(null);
            $table->string('input_color',50)->nullable()->default(null);
            $table->string('input_font_family',50)->nullable()->default(null);
            $table->string('input_font_color',50)->nullable()->default(null);
            $table->integer('input_font_size')->nullable()->default(null);
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('header_color',50)->nullable()->default(null);
            $table->string('header_font_family',50)->nullable()->default(null);
            $table->string('header_font_color',50)->nullable()->default(null);
            $table->string('header_font_size',50)->nullable()->default(null);
            $table->string('input_color',50)->nullable()->default(null);
            $table->string('input_font_family',50)->nullable()->default(null);
            $table->string('input_font_color',50)->nullable()->default(null);
            $table->integer('input_font_size')->nullable()->default(null);
        });
    }
}
