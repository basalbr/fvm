<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformacaoExtraTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('informacao_extra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_imposto')->unsigned();
            $table->foreign('id_imposto')->references('id')->on('imposto');
            $table->string('tipo');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->integer('tamanho_maximo')->nullable();
            $table->string('tabela')->nullable();
            $table->string('campo')->nullable();
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
        Schema::drop('informacao_extra');
    }

}
