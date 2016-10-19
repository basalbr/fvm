<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAberturaEmpresaCapitalSocialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abertura_empresa_capital_social', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_abertura_empresa')->unsigned();
            $table->foreign('id_abertura_empresa')->references('id')->on('abertura_empresa');        
            $table->string('descricao');
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
