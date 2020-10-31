<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersCarPartsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_car_parts_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->default('0');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->string('car_part_name')->nullable();
            $table->string('car_part_detail')->nullable();
            $table->string('car_part_image')->nullable();
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
        Schema::dropIfExists('orders_car_parts_details');
    }
}
