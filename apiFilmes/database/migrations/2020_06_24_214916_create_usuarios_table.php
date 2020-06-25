<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nmUsuario',100)->index();
            $table->string('dsSenha')->unique();
            $table->string('email')->index();
            $table->integer('confirmado')->default('0');
            $table->string('tokenCompleto')->unique();
            $table->string('tokenUsuario')->unique();
            $table->integer('cdPermissao');
            $table->dateTime('dtUpdate')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
