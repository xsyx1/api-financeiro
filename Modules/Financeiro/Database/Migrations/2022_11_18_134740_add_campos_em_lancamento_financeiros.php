<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposEmLancamentoFinanceiros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financeiro.lancamento_financeiros', function (Blueprint $table) {
            $table->dropColumn('tipo_documento');
         });
         Schema::table('financeiro.lancamento_financeiros', function (Blueprint $table) {
            $table->double('valor_pago')->default(0)->nullable();
            $table->integer('total_parcelas')->nullable();
            $table->integer('tipo_documento')->nullable()
				->description('tipos de documentos contabeis relacionados ao lancamento financeiro 
				(e.g. NOTA DE COMPRA/SERVICO, NOTA DE VENDA/SERVICO, RECIBO, BOLETO, EXTRATO BANCARIO, 
				DUPLICATA, COMPROVANTE DE DESPESA, COPIA DE CHEQUE, NOTA PROMISSORIA, etc) (ENUM)');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}
