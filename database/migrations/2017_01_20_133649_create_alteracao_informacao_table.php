<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlteracaoInformacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('alteracao_informacao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_alteracao_campo')->unsigned();
            $table->foreign('id_alteracao_campo')->references('id')->on('alteracao_campo');        
            $table->integer('id_alteracao')->unsigned();
            $table->foreign('id_alteracao')->references('id')->on('alteracao');        
            $table->string('valor');
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
