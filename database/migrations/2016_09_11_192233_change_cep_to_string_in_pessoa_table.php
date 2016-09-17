<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCepToStringInPessoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pessoa', function ($table) {
            $table->string('rg')->change();
            $table->string('iptu')->change();
            $table->string('telefone')->change();
            $table->string('cep')->change();
            $table->string('inscricao_estadual')->change();
            $table->string('inscricao_municipal')->change();
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
