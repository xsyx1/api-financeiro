<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro.transacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tid');
            $table->json('body');
            $table->string('mensagem');
            $table->integer('tranzacaotable_id')->nullable();
            $table->string('tranzacaotable_type')->nullable();
            $table->boolean('status');
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
        Schema::dropIfExists('financeiro.transacoes');
    }
}
