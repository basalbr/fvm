<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioPagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_mensalidade')->unsigned();
            $table->foreign('id_mensalidade')->references('id')->on('mensalidade');
            $table->string('status')->default('pendente');
            $table->dateTime('vencimento');
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
