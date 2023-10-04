<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentroCustoFinanceirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro.centro_custo_financeiros', function (Blueprint $table) {
            $table->increments('id');

			$table->integer('centro_custo_id')->unsigned()->nullable()->index();
			$table->foreign('centro_custo_id')->references('id')->on('financeiro.centro_custos');

			$table->integer('lancamento_financeiro_id')->unsigned()->nullable()->index();
			$table->foreign('lancamento_financeiro_id')->references('id')->on('financeiro.lancamento_financeiros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financeiro.centro_custo_financeiros');
    }
}
