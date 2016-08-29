<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessoRespostaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processo_resposta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_processo')->unsigned();
            $table->foreign('id_processo')->references('id')->on('processo');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->string('anexo')->nullable();
            $table->text('mensagem');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::drop('processo_resposta');
    }
}
