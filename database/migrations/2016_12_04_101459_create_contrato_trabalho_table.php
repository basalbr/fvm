<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratoTrabalhoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contrato_trabalho', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_funcionario')->unsigned();
            $table->foreign('id_funcionario')->references('id')->on('funcionario');
            $table->string('cargo')->nullable();
            $table->string('funcao')->nullable();
            $table->string('departamento')->nullable();
            $table->string('sindicato');
            $table->string('dsr');
            $table->boolean('sindicalizado')->nullable();
            $table->boolean('pagou_contribuicao')->nullable();
            $table->date('competencia_sindicato')->nullable();
            $table->date('data_admissao');
            $table->integer('qtde_dias_vale_transporte')->default(0);
            $table->float('valor_vale_transporte')->default(0.0);
            $table->float('valor_assistencia_medica')->default(0.0);
            $table->float('desconto_assistencia_medica')->default(0.0);
            $table->string('vinculo_empregaticio');
            $table->string('situacao_seguro_desemprego');
            $table->float('salario');
            $table->boolean('possui_banco_de_horas')->nullable();
            $table->boolean('desconta_vale_transporte')->nullable();
            $table->boolean('contrato_experiencia')->nullable();
            $table->boolean('professor')->nullable();
            $table->boolean('primeiro_emprego')->nullable();
            $table->integer('qtde_dias_experiencia')->default(0);
            $table->date('data_inicio_experiencia')->nullable();
            $table->date('data_final_experiencia')->nullable();
            $table->date('data_inicio_prorrogacao_experiencia')->nullable();
            $table->date('data_final_prorrogacao_experiencia')->nullable();
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
        //
    }

}
