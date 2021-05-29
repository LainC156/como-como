<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingUsersTable extends Migration
{
    /**
     * Run the migrations.
     * status: 0 = not activated, 1 = activated
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name');
            $table->date('birthdate')->nullable();
            $table->string('identificator')->nullable();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('account_type');
            $table->integer('nutritionist_id')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('genre')->nullable();
            $table->string('psychical_activity')->nullable();
            $table->string('caloric_requirement')->nullable();
            $table->boolean('acrc')->default(true);
            $table->string('waist_size')->nullable();
            $table->string('legs_size')->nullable();
            $table->string('wrist_size')->nullable();
            $table->text('token');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('pending_users');
    }
}
