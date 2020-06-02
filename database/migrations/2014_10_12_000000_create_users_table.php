<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * identificator: CURP/ID
     * account type: 0 = patient, 1 = nutriologist, 2 = administrator
     * subscription_status: 0 = account activated, 1 = account disabled
     * trial_version_status: 0 = expired, 1 = activated
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name');
            $table->string('identificator')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->default('user.jpg');
            $table->integer('account_type')->nullable();
            $table->boolean('subscription_status')->default(0);
            $table->boolean('trial_version_status')->default(1);
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
