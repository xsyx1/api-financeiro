<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro.lancamento_financeiros', function (Blueprint $table) {
            $table->tinyInteger('situacao_contrato')->nullable();
            $table->tinyInteger('situacao_pagamento')->nullable();
            $table->tinyInteger('tipo_parcela')->nullable();
            $table->tinyInteger('historico_situacao')->nullable();

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
            $table->dropColumn('situacao_contrato');
            $table->dropColumn('situacao_pagamento');
            $table->dropColumn('tipo_parcela');
            $table->dropColumn('historico_situacao');
        });
    }
};
