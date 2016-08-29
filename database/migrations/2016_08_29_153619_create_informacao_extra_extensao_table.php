<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformacaoExtraExtensaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('informacao_extra_extensao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_informacao_extra')->unsigned();
            $table->foreign('id_informacao_extra')->references('id')->on('informacao_extra');
            $table->string('extensao');
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
        Schema::drop('informacao_extra_extensao');
    }
}
