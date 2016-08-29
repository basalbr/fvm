<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessoInformacaoExtraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('processo_informacao_extra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_processo')->unsigned();
            $table->foreign('id_processo')->references('id')->on('processo');
            $table->integer('id_informacao_extra')->unsigned();
            $table->foreign('id_informacao_extra')->references('id')->on('informacao_extra');
            $table->string('informacao');
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
        Schema::drop('processo_informacao_extra');
    }
}
