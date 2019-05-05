<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('reg')->unique();
            $table->string('email')->unique();
            $table->string('type');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned()->unique();
            $table->foreign('user')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('surname');
            $table->string('phone', 15);
            $table->string('address');
            $table->string('number', 11);
            $table->string('district');
            $table->string('complement')->nullable();
            $table->timestamps();
        });
        Schema::create('lojistas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned()->unique();
            $table->foreign('user')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('companyname');
            $table->string('desc');
            $table->string('owner');
            $table->string('logo')->nullable();
            $table->string('phone', 15);
            $table->string('address');
            $table->string('number', 11);
            $table->string('district');
            $table->string('complement')->nullable();
            $table->double('default_delivery_fee')->default(0.0);
            $table->integer('sales')->unsigned()->default(0);
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('lojistas');
    }
}
