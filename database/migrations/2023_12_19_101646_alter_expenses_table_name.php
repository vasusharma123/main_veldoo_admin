<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterExpensesTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->double('salary', 8, 2)->nullable();
            $table->double('revenue', 8, 2)->nullable();
            $table->double('deductions', 8, 2)->nullable();
            $table->date('date')-nullable();
            $table->string('type_detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('salary');
            $table->dropColumn('revenue');
            $table->dropColumn('deductions');
            $table->dropColumn('date');
        });
    }
}
