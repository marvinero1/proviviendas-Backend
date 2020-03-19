<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiudadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciudads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pais_id')->unsigned();
            $table->foreign('pais_id')
            ->references('id')->on('pais')
            ->onDelete('cascade');
            $table->string('ciudad');
            $table->string('imagen');
            $table->string('descripcion')->nullable();
            $table->string('latitud');
            $table->string('longitud'); 
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
        Schema::dropIfExists('ciudads');
    }
}
