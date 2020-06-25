<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Nessas migrations ->onDelete('cascade') não será interessante
*/
class CreateFilmesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filme', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome')->unique();
            $table->dateTime('dtLancamento')->useCurrent();
            $table->bigInteger('idDiretor')->unsigned();
            $table->foreign('idDiretor')->references('id')->on('diretor');
            $table->integer('classificacao');
            $table->string('genero',155)->index();
            $table->integer('duracao');
            $table->integer('qtdeOscar');
            $table->longText('resumo');
            $table->longText('urlTrailer',250);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filmes');
    }
}
