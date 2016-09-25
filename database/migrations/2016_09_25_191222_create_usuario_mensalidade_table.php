<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioMensalidadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('mensalidade', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->integer('id_pessoa')->unsigned();
            $table->foreign('id_pessoa')->references('id')->on('pessoa');
            $table->float('valor');
            $table->integer('duracao');
            $table->integer('documentos_fiscais')->nullable();
            $table->integer('documentos_contabeis')->nullable();
            $table->integer('pro_labores')->nullable();
            $table->integer('funcionarios')->nullable();
            $table->string('tipo')->default('normal');
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
