<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('user_name')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->text('image');
            $table->text('location');
            $table->text('location_2');
            $table->text('lat');
            $table->text('lng');
            $table->tinyInteger('user_type')->comment = '1=>Admin,2=>Customer';
            $table->tinyInteger('signup_type')->default(1)->comment = '1=>Normal,2=>Google,3=>Facebook';
            $table->text('social_id');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('status')->default(0)->comment = '1=>Admin,2=>Customer';
            $table->tinyInteger('verify')->default(0)->comment = '1=>Verifed,0=>Not Verifed';
            $table->tinyInteger('deleted')->default(0)->comment = '1=>Deleted,0=>Not Deleted';
			$table->string('device_type')->comment = 'android,ios';
			$table->string('device_token');
			$table->string('fcm_token');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
