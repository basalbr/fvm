<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAberturaEmpresaComentarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('abertura_empresa_comentario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usuario');        
            $table->integer('id_abertura_empresa')->unsigned();
            $table->foreign('id_abertura_empresa')->references('id')->on('abertura_empresa');        
            $table->text('mensagem');
            $table->string('anexo')->nullable();
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
        Schema::drop('abertura_empresa_comentario');
    }
}
