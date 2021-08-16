<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tarefa extends Migration
{

    public function up()
    {
        Schema::create('tarefa', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id');
            $table->integer('status');
            $table->string('descricao');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete("restrict");

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tarefa');
    }
}
