<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAberturaEmpresaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        
        Schema::create('abertura_empresa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->string('nome_empresarial1');
            $table->string('nome_empresarial2');
            $table->string('nome_empresarial3');
            $table->string('enquadramento');
            $table->text('capital_social');
            $table->integer('id_natureza_juridica')->unsigned();
            $table->foreign('id_natureza_juridica')->references('id')->on('natureza_juridica');
            $table->integer('id_tipo_tributacao')->unsigned();
            $table->foreign('id_tipo_tributacao')->references('id')->on('tipo_tributacao');
            $table->string('cep');
            $table->integer('id_uf')->unsigned();
            $table->foreign('id_uf')->references('id')->on('uf');
            $table->string('cidade');
            $table->string('endereco');
            $table->string('bairro');
            $table->integer('numero');
            $table->string('complemento')->nullable();
            $table->string('iptu');
            $table->integer('area_total');
            $table->integer('area_ocupada');
            $table->string('cpf_cnpj_proprietario');
            $table->text('cnae_duvida')->nullable();
            $table->string('status_pagamento')->default('aguardando');
            $table->string('status')->default('aberto');
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
        Schema::drop('abertura_empresa');
    }

}
