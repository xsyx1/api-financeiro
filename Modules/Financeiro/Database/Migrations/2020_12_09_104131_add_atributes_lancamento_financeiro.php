<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAtributesLancamentoFinanceiro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro.lancamento_financeiros', function (Blueprint $table) {
            $table->string('descricao_caixa')->nullable();
            $table->string('historico')->nullable();
            $table->string('numero_documento')->nullable();
            $table->integer('status_lancamento')->nullable();
            $table->integer('origem_lancamento')->nullable();
            $table->timestamp('data_vencimento_renegociacao')->nullable();
            $table->timestamp('data_pagamento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financeiro.lancamento_financeiros', function (Blueprint $table) {
            $table->dropColumn('descricao_caixa');
            $table->dropColumn('data_vencimento_renegociacao');
            $table->dropColumn('data_pagamento');
            $table->dropColumn('historico');
            $table->dropColumn('status_lancamento');
            $table->dropColumn('fornecedor_id');
        });
    }
}
