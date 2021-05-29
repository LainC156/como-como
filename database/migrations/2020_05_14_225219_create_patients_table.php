<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     * acrc = automatic caloric requirement calculation
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('nutritionist_id')->unsigned()->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('genre')->nullable();
            $table->string('psychical_activity')->nullable();
            $table->string('caloric_requirement')->nullable();
            $table->boolean('acrc')->default(true);
            $table->string('waist_size')->nullable();
            $table->string('legs_size')->nullable();
            $table->string('wrist_size')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
