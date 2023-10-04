<?php

namespace Modules\Financeiro\Console;

use Illuminate\Console\Command;
use Modules\Financeiro\Services\LancamentoFinanceiroService;

class NovoModeloLançamentoCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'lancamento:camposNovos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ajusta os valores de todos os Campos de situação do pagamento e tipo de parcela e demais campos novos.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(LancamentoFinanceiroService $lancamentoFinanceiroService)
    {
		$lancamentoFinanceiroService->ajustarCampos();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            //['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            //['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
