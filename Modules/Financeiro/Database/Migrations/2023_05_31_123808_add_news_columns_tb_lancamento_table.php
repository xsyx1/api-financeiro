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
            $table->date('data_credito')->nullable();
            $table->date('data_competencia')->nullable();
            $table->date('data_correcao')->nullable();
            $table->date('data_prorrogada')->nullable();
            $table->date('data_vencimento')->nullable()->change();
            $table->bigInteger('usuario_desconto')->unsigned()->nullable();
            $table->foreign('usuario_desconto')->references('id')->on('core.users');
            $table->tinyInteger('tipo_movimentacao')->nullable();
            $table->longText('historico')->nullable()->change();
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
            $table->dropColumn('data_credito');
            $table->dropColumn('data_competencia');
            $table->dropColumn('data_correcao');
            $table->dropColumn('data_prorrogada');
            $table->dropColumn('tipo_movimentacao');
            $table->dropForeign(['usuario_desconto']);
            $table->dropColumn('usuario_desconto');
        });
    }
};
