<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     * kind_of menu: 0 = created menu 'menu consumido' , 1 = menu saved(ideal) -ha sido editado por el nutriólogo-
     *                  -- menu consumido ideal --
     *               2 = copied menu from another user, 3 = edited menu from another user
     *
     * status: 1 = in use, 0 = deleted
     * ideal: 1 = true, 0 = false
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('kind_of_menu')->default(0);
            $table->boolean('status')->default('1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
