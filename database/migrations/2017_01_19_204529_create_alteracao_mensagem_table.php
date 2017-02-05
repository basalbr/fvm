<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlteracaoMensagemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('alteracao_mensagem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_alteracao')->unsigned();
            $table->foreign('id_alteracao')->references('id')->on('alteracao');        
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usuario');        
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
        //
    }
}
