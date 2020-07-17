<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('id')->references('id')->on('menus')->onDelete('cascade');
            /* macros */
            $table->float('carbohydrates')->nullable();
            $table->integer('carbohydratesStatus')->nullable();
            $table->float('proteins')->nullable();
            $table->integer('proteinsStatus')->nullable();
            $table->float('lipids')->nullable();
            $table->integer('lipidsStatus')->nullable();
            /* micros */
            $table->float('calcium')->nullable();
            $table->integer('calciumStatus')->nullable();
            $table->float('phosphorus')->nullable();
            $table->integer('phosphorusStatus')->nullable();
            $table->float('iron')->nullable();
            $table->integer('ironStatus')->nullable();
            $table->float('magnesium')->nullable();
            $table->integer('magnesiumStatus')->nullable();
            $table->float('sodium')->nullable();
            $table->integer('sodiumStatus')->nullable();
            $table->float('potassium')->nullable();
            $table->integer('potassiumStatus')->nullable();
            $table->float('zinc')->nullable();
            $table->integer('zincStatus')->nullable();
            $table->float('vitaminA')->nullable();
            $table->integer('vitaminAStatus')->nullable();
            $table->float('vitaminB1')->nullable();
            $table->integer('vitaminB1Status')->nullable();
            $table->float('vitaminB2')->nullable();
            $table->integer('vitaminB2Status')->nullable();
            $table->float('vitaminB3')->nullable();
            $table->integer('vitaminB3Status')->nullable();
            $table->float('vitaminB6')->nullable();
            $table->integer('vitaminB6Status')->nullable();
            $table->float('vitaminB9')->nullable();
            $table->integer('vitaminB9Status')->nullable();
            $table->float('vitaminB12')->nullable();
            $table->integer('vitaminB12Status')->nullable();
            $table->float('vitaminC')->nullable();
            $table->integer('vitaminCStatus')->nullable();
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
        Schema::dropIfExists('results');
    }
}
