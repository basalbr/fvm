<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabelaSimplesNacionalValorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('tabela_simples_nacional_valor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tabela_simples_nacional')->unsigned();
            $table->foreign('id_tabela_simples_nacional')->references('id')->on('tabela_simples_nacional');
            $table->float('receita_de')->nullable();
            $table->float('receita_ate')->nullable();
            $table->float('aliquota_total')->nullable();
            $table->float('irpj')->nullable();
            $table->float('csll')->nullable();
            $table->float('cofins')->nullable();
            $table->float('pis_pasep')->nullable();
            $table->float('cpp')->nullable();
            $table->float('icms')->nullable();
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
        Schema::drop('tabela_simples_nacional_valor');
    }
}
