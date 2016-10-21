<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoToPagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('pagamento', function($table) {
            $table->string('tipo')->default('mensalidade');
            $table->integer('id_mensalidade')->unsigned()->nullable()->change();
            $table->integer('id_abertura_empresa')->unsigned()->nullable();
            $table->foreign('id_abertura_empresa')->references('id')->on('abertura_empresa');
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
