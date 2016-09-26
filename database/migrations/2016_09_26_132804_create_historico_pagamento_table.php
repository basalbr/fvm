<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoPagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('historico_pagamento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pagamento')->unsigned();
            $table->foreign('id_pagamento')->references('id')->on('pagamento');
            $table->string('transaction_id');
            $table->string('status');
            $table->string('forma_pagamento');
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
