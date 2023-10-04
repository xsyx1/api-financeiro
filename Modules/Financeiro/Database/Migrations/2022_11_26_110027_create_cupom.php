<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCupom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro.cupons_descontos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('codigo')->unique();
            $table->integer('status')->default(1);
            $table->double('valor');
            $table->integer('tipo');
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
        Schema::dropIfExists('financeiro.cupons');
    }
}
