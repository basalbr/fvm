<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAberturaEmpresaCnaeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abertura_empresa_cnae', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_abertura_empresa')->unsigned();
            $table->foreign('id_abertura_empresa')->references('id')->on('abertura_empresa');
            $table->integer('id_cnae')->unsigned();
            $table->foreign('id_cnae')->references('id')->on('cnae');
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
        //
    }
}
