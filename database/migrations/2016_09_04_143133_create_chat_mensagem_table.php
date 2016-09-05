<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatMensagemTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('chat_mensagem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_chat')->unsigned()->nullable();
            $table->foreign('id_chat')->references('id')->on('chat');
            $table->integer('id_atendente')->unsigned()->nullable();
            $table->foreign('id_atendente')->references('id')->on('usuario');
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
    public function down() {
        Schema::drop('chat_mesagem');
    }

}
