<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIrrfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('irrf', function (Blueprint $table) {
            $table->increments('id');
            $table->float('de')->nullable();
            $table->float('ate')->nullable();
            $table->float('aliquota')->nullable();
            $table->float('parcela_reduzir')->nullable();
            $table->softDeletes();
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
          Schema::drop('irrf');
    }
}
