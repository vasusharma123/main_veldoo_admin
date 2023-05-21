<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceProviderIdToVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->nullable();
        });

        Schema::table('vouchers', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 1')->change();
            $table->index('service_provider_id');
            $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropForeign('vouchers_service_provider_id_foreign');
            $table->dropIndex('vouchers_service_provider_id_index');
        });

        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn('service_provider_id');
        });
    }
}
