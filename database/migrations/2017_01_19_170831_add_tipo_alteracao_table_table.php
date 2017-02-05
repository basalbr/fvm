<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoAlteracaoTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('alteracao', function (Blueprint $table) {
            $table->dropColumn('descricao');
            $table->integer('id_tipo_alteracao')->unsigned();
            $table->foreign('id_tipo_alteracao')->references('id')->on('tipo_alteracao');
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
