<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float("precio", 8, 2)->nullable();
            $table->float("descuento", 8, 2)->nullable();
            $table->float("total", 8, 2)->nullable();
            $table->integer('dias')->nullable();
            $table->string('plan')->nullable();;
            $table->text('detalle')->nullable();
            $table->enum('estado',['activo','inactivo'])->nullable();
            $table->unsignedBigInteger('pais_id');
            $table->foreign('pais_id')->references('id')->on('pais')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('plans');
    }
}
