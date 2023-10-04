<?php

namespace Modules\Financeiro\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Financeiro\Enuns\Periodicidade;
use Modules\Financeiro\Services\LancamentoFinanceiroService;

class GerarParcelamento implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


	/**
	 * @var
	 */
	private $dados;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($dados)
	{
		$this->dados = $dados;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		try {
			app(LancamentoFinanceiroService::class)->gerarRepeticao(
				$this->dados['idLancamento'],
				$this->dados['ocorrencias'],
				$this->dados['periodicidade'],
				isset($this->dados['isParcelamento']) ? $this->dados['isParcelamento'] : true);
		} catch (\Exception $e) {
			print $e->getMessage() . 'arquivo: ' . $e->getFile() . ' linha: ' . $e->getLine();
		}
	}


}
