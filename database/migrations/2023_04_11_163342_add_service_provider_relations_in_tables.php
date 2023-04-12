<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceProviderRelationsInTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 1')->change();
            $table->index('service_provider_id');
            $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 1')->change();
            $table->index('service_provider_id');
            $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 1')->change();
            $table->index('service_provider_id');
            $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 1')->change();
            $table->index('service_provider_id');
            $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('rides', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 1')->change();
            $table->index('service_provider_id');
            $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->unsignedBigInteger('service_provider_id')->default(null)->nullable()->comment('foreign key of users table where user_type = 1')->change();
            $table->index('service_provider_id');
            $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('sms_templates', function (Blueprint $table) {
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
        Schema::table('prices', function (Blueprint $table) {
            $table->dropForeign('prices_service_provider_id_foreign');
            $table->dropIndex('prices_service_provider_id_index');
        });
        Schema::disableForeignKeyConstraints();
        Schema::table('prices', function (Blueprint $table) {
            $table->integer('service_provider_id')->change();
        });
        Schema::enableForeignKeyConstraints();


        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign('vehicles_service_provider_id_foreign');
            $table->dropIndex('vehicles_service_provider_id_index');
        });
        Schema::disableForeignKeyConstraints();
        Schema::table('vehicles', function (Blueprint $table) {
            $table->integer('service_provider_id')->change();
        });
        Schema::enableForeignKeyConstraints();


        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign('settings_service_provider_id_foreign');
            $table->dropIndex('settings_service_provider_id_index');
        });
        Schema::disableForeignKeyConstraints();
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('service_provider_id')->change();
        });
        Schema::enableForeignKeyConstraints();


        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_service_provider_id_foreign');
            $table->dropIndex('users_service_provider_id_index');
        });
        Schema::disableForeignKeyConstraints();
        Schema::table('users', function (Blueprint $table) {
            $table->integer('service_provider_id')->change();
        });
        Schema::enableForeignKeyConstraints();


        Schema::table('rides', function (Blueprint $table) {
            $table->dropForeign('rides_service_provider_id_foreign');
            $table->dropIndex('rides_service_provider_id_index');
        });
        Schema::disableForeignKeyConstraints();
        Schema::table('rides', function (Blueprint $table) {
            $table->integer('service_provider_id')->change();
        });
        Schema::enableForeignKeyConstraints();

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropForeign('payment_methods_service_provider_id_foreign');
            $table->dropIndex('payment_methods_service_provider_id_index');
        });
        Schema::disableForeignKeyConstraints();
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->integer('service_provider_id')->change();
        });
        Schema::enableForeignKeyConstraints();

        Schema::table('sms_templates', function (Blueprint $table) {
            $table->dropForeign('sms_templates_service_provider_id_foreign');
            $table->dropIndex('sms_templates_service_provider_id_index');
        });
        Schema::disableForeignKeyConstraints();
        Schema::table('sms_templates', function (Blueprint $table) {
            $table->integer('service_provider_id')->change();
        });
        Schema::enableForeignKeyConstraints();
    }
}
