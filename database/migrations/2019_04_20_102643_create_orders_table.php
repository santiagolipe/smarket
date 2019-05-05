<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned();
            $table->foreign('user')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->integer('market')->unsigned();
            $table->foreign('market')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->string('delivery');
            $table->string('address');
            $table->string('number');
            $table->string('district');
            $table->string('payment');
            $table->double('subtotal');
            $table->double('delivery_fee');
            $table->double('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('orders');
    }
}
