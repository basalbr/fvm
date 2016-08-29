<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticiaTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticia_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_noticia')->unsigned();
            $table->foreign('id_noticia')->references('id')->on('noticia');
            $table->string('tag');
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
       Schema::drop('noticia_tag');
    }
}
