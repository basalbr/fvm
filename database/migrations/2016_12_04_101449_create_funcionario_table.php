<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pessoa')->unsigned();
            $table->foreign('id_pessoa')->references('id')->on('pessoa');
            $table->string('nome_completo');
            $table->string('nome_mae');
            $table->string('nome_pai');
            $table->string('nome_conjuge')->nullable();
            $table->string('nacionalidade');
            $table->string('naturalidade');
            $table->string('grau_instrucao');
            $table->string('grupo_sanguineo');
            $table->string('raca_cor');
            $table->string('sexo');
            $table->date('data_nascimento');
            $table->string('cpf');
            $table->string('rg');
            $table->string('orgao_expeditor_rg');
            $table->date('data_emissao_rg');
            $table->string('numero_titulo_eleitoral');
            $table->string('zona_secao_eleitoral');
            $table->string('numero_carteira_reservista')->nullable();
            $table->string('categoria_carteira_reservista')->nullable();
            $table->string('numero_carteira_motorista')->nullable();
            $table->string('categoria_carteira_motorista')->nullable();
            $table->string('vencimento_carteira_motorista')->nullable();
            $table->string('email');
            $table->string('telefone');
            $table->string('data_chegada_estrangeiro')->nullable();
            $table->string('condicao_trabalhador_estrangeiro')->nullable();
            $table->string('numero_processo_mte')->nullable();
            $table->string('validade_carteira_trabalho')->nullable();
            $table->boolean('casado_estrangeiro')->nullable();
            $table->boolean('filho_estrangeiro')->nullable();
            $table->string('numero_rne')->nullable();
            $table->string('orgao_emissor_rne')->nullable();
            $table->string('data_validade_rne')->nullable();
            $table->string('cep');
            $table->string('bairro');
            $table->integer('id_uf')->unsigned();
            $table->foreign('id_uf')->references('id')->on('uf');
            $table->string('endereco');
            $table->string('numero');
            $table->string('cidade');
            $table->string('complemento')->nullable();
            $table->boolean('residente_exterior')->nullable();
            $table->boolean('residencia_propria')->nullable();
            $table->boolean('imovel_recurso_fgts')->nullable();
            $table->string('pis');
            $table->string('data_cadastro_pis');
            $table->string('ctps');
            $table->string('data_expedicao_ctps');
            $table->integer('id_uf_ctps')->unsigned();
            $table->foreign('id_uf_ctps')->references('id')->on('uf');
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
