<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('orderitems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order')->unsigned();
            $table->foreign('order')->references('id')->on('orders')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->integer('product')->unsigned();
            $table->foreign('product')->references('id')->on('products')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->integer('qty')->unsigned();
            $table->double('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('orderitems');
    }
}
