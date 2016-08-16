<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCnaeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cnae', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tabela_simples_nacional')->unsigned()->nullable();
            $table->foreign('id_tabela_simples_nacional')->references('id')->on('tabela_simples_nacional');
            $table->string('descricao');
            $table->string('codigo');
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
        Schema::drop('cnae');
    }

}
