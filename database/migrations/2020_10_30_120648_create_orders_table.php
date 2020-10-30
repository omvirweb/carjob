<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('mobile_no')->nullable();
            $table->date('order_date')->nullable();
            $table->time('order_time')->nullable();
            $table->unsignedBigInteger('car_id')->default('0');
            $table->foreign('car_id')->references('id')->on('cars');
            $table->unsignedBigInteger('car_model_id')->default('0');
            $table->foreign('car_model_id')->references('id')->on('car_models');
            $table->string('model_year')->nullable();
            $table->string('mileage')->nullable();
            $table->unsignedBigInteger('receiver_id')->default('0');
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->date('expected_delivery_date')->nullable();
            $table->double('price', 8, 2)->default('0');
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
        Schema::dropIfExists('orders');
    }
}
