<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->default('0');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->unsignedBigInteger('task_id')->default('0');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->integer('task_value')->default('0')->comment('0 = Uncheck, 1 = Checked');
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
        Schema::dropIfExists('orders_tasks');
    }
}
