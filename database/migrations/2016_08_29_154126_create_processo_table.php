<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_imposto')->unsigned();
            $table->foreign('id_imposto')->references('id')->on('imposto');
            $table->integer('id_pessoa')->unsigned();
            $table->foreign('id_pessoa')->references('id')->on('pessoa');
            $table->enum('status',['concluido','pendente','cancelado','atencao']);
            $table->date('competencia');
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
        Schema::drop('processo');
    }
}
