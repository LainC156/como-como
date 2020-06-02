<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('some_value')->nullable(); /// in DB always in NULL
            $table->float('kcal')->nullable();
            $table->float('kj')->nullable();
            $table->float('water')->nullable();
            $table->float('dietary_fiber')->nullable();
            $table->float('carbohydrates')->nullable();
            $table->float('proteins')->nullable();
            $table->float('total_lipids')->nullable();
            $table->float('saturated_lipids')->nullable();
            $table->float('monosaturated_lipids')->nullable();
            $table->float('polysaturated_lipids')->nullable();
            $table->float('cholesterol')->nullable();
            $table->float('calcium')->nullable();
            $table->float('phosphorus')->nullable();
            $table->float('iron')->nullable();
            $table->float('magnesium')->nullable();
            $table->float('sodium')->nullable();
            $table->float('potassium')->nullable();
            $table->float('zinc')->nullable();
            $table->float('vitamin_a')->nullable();
            $table->float('ascorbic_acid')->nullable();
            $table->float('thiamin')->nullable();
            $table->float('rivoflavin')->nullable();
            $table->float('niacin')->nullable();
            $table->float('pyridoxine')->nullable();
            $table->float('folic_acid')->nullable();
            $table->float('cobalamin')->nullable();
            $table->float('edible_percentage')->nullable();
            /* unknow values */
            $table->float('one')->nullable();
            $table->float('two')->nullable();
            $table->float('three')->nullable();
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
        Schema::dropIfExists('foods');
    }
}
