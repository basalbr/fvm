<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pessoa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->integer('id_natureza_juridica')->unsigned();
            $table->foreign('id_natureza_juridica')->references('id')->on('natureza_juridica');
            $table->enum('tipo', ['F', 'J']);
            $table->bigInteger('cpf_cnpj');
            $table->bigInteger('inscricao_estadual');
            $table->bigInteger('inscricao_municipal');
            $table->bigInteger('iptu');
            $table->integer('rg')->nullable();
            $table->integer('qtde_funcionarios');
            $table->string('email');
            $table->bigInteger('telefone');
            $table->string('responsavel');
            $table->string('nome')->nullable();
            $table->string('nome_fantasia');
            $table->string('razao_social');
            $table->integer('ramal')->nullable();
            $table->string('endereco');
            $table->string('bairro');
            $table->integer('numero')->nullable();
            $table->integer('cep');
            $table->string('cidade');
            $table->string('estado');
            $table->string('nacionalidade')->nullable();
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
        Schema::drop('pessoa');
    }

}
