<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLancamentoFinanceirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financeiro.lancamento_financeiros', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('parent_id')->unsigned()->nullable()->index()
				->description('usado para agrupar os lançamentos');
			$table->foreign('parent_id')->references('id')->on('financeiro.lancamento_financeiros');
			$table->integer('filial_id')->unsigned()->nullable()->index()
				->description('chave estrangeira para a tabela filial que indica para qual filial está sendo realizada o lançamento
				financeiro.');
			$table->foreign('filial_id')->references('id')->on('core.filiais');

			$table->integer('conta_financeiro_id')->unsigned()->nullable()->index()
			->description('cliente que ira pagar ou fornecedor que esta sendo pago pelo lancamento financeiro');
			$table->foreign('conta_financeiro_id')->references('id')->on('financeiro.conta_financeiros');

			$table->integer('usuario_id')->unsigned()->nullable()->index()
				->description('');
			$table->foreign('usuario_id')->references('id')->on('core.users');

			$table->integer('plano_conta_id')->unsigned()->nullable()->index()
				->description('id de identificacao do objeto gerador do lancamento (e.g. id do Contrato, id do veiculo, etc)');
			$table->foreign('plano_conta_id')->references('id')->on('financeiro.plano_contas');

			$table->string('tipo_documento')->nullable()
				->description('tipos de documentos contabeis relacionados ao lancamento financeiro
				(e.g. NOTA DE COMPRA/SERVICO, NOTA DE VENDA/SERVICO, RECIBO, BOLETO, EXTRATO BANCARIO,
				DUPLICATA, COMPROVANTE DE DESPESA, COPIA DE CHEQUE, NOTA PROMISSORIA, etc) (ENUM)');

			$table->timestamp('data_arq_remessa')->nullable()
				->description('data em que foi gerado o arquivo de remessa do lancamento financeiro');

			$table->timestamp('data_baixa')->nullable()
				->desctiption('data em que foi realizado a baixa');

			$table->timestamp('data_conciliacao')->nullable()
				->desctiption('data em que foi realizado a conciliacao bancaria do lancamento financeiro');

			$table->timestamp('data_efetivacao')->nullable()
				->desctiption('data em que o debito ou credito foi realmente efetuado');

			$table->timestamp('data_emissao')->nullable()
				->desctiption('data em que o documento que gerou o lancamento financeiro foi emitido');

			$table->timestamp('data_ult_cobranca')->nullable()
				->desctiption('Data mais recente em que um lançamento financeiro em atraso foi carregado para a
				tela de cobrança. Essa data deve ser alimentada assim que o sistema carrega o débito para a tela de
				cobrança de um determinado usuario. O mesmo débito não poderá ser selecionado para cobrança mais
				de uma vez no mesmo dia.');

			$table->timestamp('data_vencimento')
				->desctiption('data de vencimento do lancemanto financeiro');

			$table->text('descricao');
			$table->string('tipo')->description('Enum de crédigo ou débito.');
			$table->string('agrupados')->description('ids que foram agrupados para gerar o lançamento.')->nullable();
			$table->integer('num_parcela')->nullable();
			$table->string('modulo');
			$table->boolean('protocolar')->nullable();
			$table->boolean('bloqueado')->default(false);
			$table->integer('qtd_dias_carencia_juros')->nullable();
			$table->integer('qtd_dias_carencia_multa')->nullable();
			$table->boolean('recorrente')->nullable();
			$table->integer('situacao_lancamento')->default(0)
				->description('e.g. Aberto, Liquidado, Aguardando Compensacao de Cheque, Negociada, etc. (ENUM)');
			$table->double('taxa_correcao_monetaria')->nullable();
			$table->double('taxa_juros')->default(0)->nullable();
			$table->double('taxa_multa')->default(0)->nullable();
			$table->double('valor_original')->default(0);
			$table->double('saldo')->default(0)->nullable();
			$table->double('valor_correcao_monetaria')->nullable()->deafult(0);
			$table->double('valor_desconto')->default(0)->nullable();
			$table->double('valor_juros')->default(0)->nullable();
			$table->double('valor_multa')->default(0)->nullable();
			$table->double('valor_outros')->default(0)->nullable();
			$table->double('valor_taxa_bancaria')->default(0)->nullable();
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
        Schema::dropIfExists('financeiro.lancamento_financeiros');
    }
}
