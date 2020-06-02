<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            /* FK from foods table */
            $table->integer('food_id')->unsigned();
            $table->foreign('food_id')->references('id')->on('foods');
            /* FK from menus table */
            $table->integer('menu_id')->unsigned();
            $table->foreign('menu_id')->references('id')->on('menus');
            $table->float('food_weight');
            $table->integer('kind_of_food');
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
        Schema::dropIfExists('components');
    }
}
