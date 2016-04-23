<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpostoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('imposto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('vencimento')->unsigned();
            $table->boolean('antecipa_posterga');
            $table->boolean('recebe_documento');
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
        Schema::drop('imposto');
    }

}
