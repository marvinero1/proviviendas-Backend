<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();

            $table->unsignedBigInteger('forma_pago_id');
            $table->foreign('forma_pago_id')
            ->references('id')->on('forma_pagos')
            ->onDelete('cascade');

            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')
            ->references('id')->on('plans')
            ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            
            // $table->integer('usuario_id')->unsigned();
            // $table->foreign('usuario_id')
            // ->references('id')->on('usuarios')
            // ->onDelete('cascade');
            $table->string('nit')->nullable();
            $table->string('transaccion')->nullable();
            // $table->text('imagen')->nullable();
            $table->text('detalle')->nullable();
            $table->float("pago", 8, 2);
            $table->date('inicio')->nullable();
            $table->date('fin')->nullable();
            $table->enum('estado',['confirmado','pendiente','revocado']);
            $table->softDeletes();
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
        Schema::dropIfExists('pagos');
    }
}
