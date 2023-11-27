<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePlanPurchaseHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_purchase_history', function (Blueprint $table) {
            $table->string('license_type');
            $table->enum('plan_status', ['active', 'expired'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_purchase_history', function (Blueprint $table) {
            $table->dropColumn('license_type');
            $table->dropColumn('plan_status');
        });
    }
}
