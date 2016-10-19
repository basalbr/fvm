<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAberturaEmpresaSocioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abertura_empresa_socio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_abertura_empresa')->unsigned();
            $table->foreign('id_abertura_empresa')->references('id')->on('abertura_empresa');
            $table->string('nome');
            $table->string('nome_mae');
            $table->string('nome_pai');
            $table->boolean('principal');
            $table->date('data_nascimento');
            $table->string('estado_civil');
            $table->string('regime_casamento');
            $table->string('email');
            $table->string('telefone');
            $table->string('cpf');
            $table->string('rg');
            $table->string('orgao_expedidor');
            $table->string('nacionalidade');
            $table->string('cep');
            $table->integer('id_uf')->unsigned();
            $table->foreign('id_uf')->references('id')->on('uf');
            $table->string('endereco');
            $table->integer('numero');
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cidade');
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
        //
    }
}
