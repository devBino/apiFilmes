<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Nessas migrations ->onDelete('cascade') não será interessante
*/
class CreateElencosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elenco', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idFilme')->unsigned();
            $table->foreign('idFilme')->references('id')->on('filme');
            $table->bigInteger('idAtor')->unsigned();
            $table->foreign('idAtor')->references('id')->on('ator');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elencos');
    }
}
