<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionarioDependenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('funcionario_dependente', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_funcionario')->unsigned();
            $table->foreign('id_funcionario')->references('id')->on('funcionario');
            $table->string('nome');
            $table->date('data_nascimento');
            $table->string('local_nascimento')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('orgao_rg')->nullable();
            $table->string('tipo_dependencia')->nullable();
            $table->string('matricula')->nullable();
            $table->string('cartorio')->nullable();
            $table->string('numero_cartorio')->nullable();
            $table->string('numero_folha')->nullable();
            $table->string('numero_dnv')->nullable();
            $table->date('data_entrega_documento')->nullable();
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
