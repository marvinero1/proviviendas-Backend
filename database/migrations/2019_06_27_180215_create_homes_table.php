<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->enum('oferta', ['venta','alquiler','anticretico']);
            $table->enum('estado', ['pendiente','aceptado','inactivo']);
            $table->string('direccion')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->string('precio')->nullable();

            $table->unsignedBigInteger('tipo_id');
            $table->foreign('tipo_id')
            ->references('id')->on('tipos')
            ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->unsignedBigInteger('ciudad_id');
            $table->foreign('ciudad_id')
            ->references('id')->on('ciudads')
            ->onDelete('cascade');
            
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
        Schema::dropIfExists('homes');
    }
}
