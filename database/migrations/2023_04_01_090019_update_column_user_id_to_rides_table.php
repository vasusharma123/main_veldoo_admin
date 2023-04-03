<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnUserIdToRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 1')->change();
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->dropForeign('rides_user_id_foreign');
            $table->dropIndex('rides_user_id_index');
        });
        Schema::disableForeignKeyConstraints();
        Schema::table('rides', function (Blueprint $table) {
            $table->integer('user_id')->change();
        });
        Schema::enableForeignKeyConstraints();
    }
}
