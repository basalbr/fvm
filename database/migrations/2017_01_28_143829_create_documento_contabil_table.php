<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentoContabilTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('documento_contabil', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_processo_documento_contabil')->unsigned();
            $table->foreign('id_processo_documento_contabil')->references('id')->on('processo_documento_contabil');
            $table->string('descricao');
            $table->string('anexo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
