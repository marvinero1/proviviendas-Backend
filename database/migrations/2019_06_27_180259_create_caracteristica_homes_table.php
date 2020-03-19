<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaracteristicaHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caracteristica_homes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('caracteristica_id');
            $table->foreign('caracteristica_id')
            ->references('id')->on('caracteristicas')
            ->onDelete('cascade');
            
            $table->unsignedBigInteger('home_id');
            $table->foreign('home_id')
            ->references('id')->on('homes')
            ->onDelete('cascade');
            $table->string('valor');
            $table->string('descripcion')->nullable();
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
        Schema::dropIfExists('caracteristica_homes');
    }
}
