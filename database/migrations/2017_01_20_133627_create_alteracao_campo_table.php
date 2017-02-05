<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlteracaoCampoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('alteracao_campo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tipo_alteracao')->unsigned();
            $table->foreign('id_tipo_alteracao')->references('id')->on('tipo_alteracao');        
            $table->string('nome');
            $table->string('descricao');
            $table->string('tipo')->default('string');        
            $table->string('tabela')->nullable();
            $table->string('coluna')->nullable();
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
