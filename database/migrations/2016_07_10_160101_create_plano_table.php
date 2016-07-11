<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanoTable extends Migration
{
       /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('plano', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('duracao')->unsigned();
            $table->float('valor');
            $table->string('nome');
            $table->text('descricao');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('plano');
    }
}
