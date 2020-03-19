<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('reportetable_id');//Polymorphic Relations

            $table->string('reportetable_type');
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            
            $table->enum('reporte',['fraude','inapropiado','otro']);
            $table->text('descripcion')->nullable(); 
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
        Schema::dropIfExists('reportes');
    }
}
