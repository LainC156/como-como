<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     * payment_status: 0 = without payment, 1 = with payment
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('trial_status')->default(1);
            $table->integer('active')->default(0);
            $table->string('payment_status')->nullable();
            $table->string('recurring_id')->nullable();
            $table->float('amount')->default(0.0);
            $table->string('currency_unit')->default('MXN');
            $table->string('payment_method')->nullable();
            $table->date('current_date')->default( Carbon::now() );
            $table->date('expiration_date')->default( Carbon::now()->addMonths(1) );
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
        Schema::dropIfExists('payments');
    }
}
