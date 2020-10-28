<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_details', function (Blueprint $table) {
            $table->id();
            $table->integer('categoryid')->default('0');
            $table->integer('itemid')->default('0');
            $table->double('weight', 8, 3)->default('0');
            $table->double('less', 8, 3)->default('0');
            $table->double('net_wt', 8, 3)->default('0');
            $table->double('purity', 8, 2)->default('0');
            $table->double('fine', 8, 3)->default('0');
            $table->integer('size')->default('0');
            $table->string('remarks')->nullable();
            $table->string('item_image')->nullable();
            $table->enum('item_available', ['0','1'])->default('1')->comment('0 = Not Available, 1 = Available');
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
        Schema::dropIfExists('item_details');
    }
}
