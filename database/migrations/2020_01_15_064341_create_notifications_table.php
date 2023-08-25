<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('user_id')->nullable();
			$table->unsignedBigInteger('user_id_op')->nullable();
			$table->bigInteger('operation_id');	
			$table->string('title');
			$table->longText('description');
			$table->tinyInteger('type');
			$table->tinyInteger('status')->default(0)->comment = '0=>UnRead,1=>Read';
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id_op')->references('id')->on('users')->onDelete('cascade');
			$table->bigInteger('timestamp');	
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
