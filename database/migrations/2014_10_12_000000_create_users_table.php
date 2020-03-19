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
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->unsignedBigInteger('ciudad_id');
            $table->foreign('ciudad_id')
            ->references('id')->on('ciudads')
            ->onDelete('cascade')->nullable();            
            $table->string('whatsapp')->nullable();
            $table->string('celular')->nullable();
            $table->string('telefono')->nullable();
            $table->string('imagen')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('rol', ['root','administrador', 'usuario', 'corredor','inmobiliaria']);
            $table->enum('sexo', ['femenino','masculino']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
