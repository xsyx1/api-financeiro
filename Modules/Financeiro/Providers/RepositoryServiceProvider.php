<?php

namespace Modules\Financeiro\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Financeiro\Repositories\CentroCustoRepository;
use Modules\Financeiro\Repositories\CentroCustoRepositoryEloquent;
use Modules\Financeiro\Repositories\ConfigGeralFinanceiroRepository;
use Modules\Financeiro\Repositories\ConfigGeralFinanceiroRepositoryEloquent;
use Modules\Financeiro\Repositories\ContaFinanceiroRepository;
use Modules\Financeiro\Repositories\ContaFinanceiroRepositoryEloquent;
use Modules\Financeiro\Repositories\CupomDescontoRepository;
use Modules\Financeiro\Repositories\CupomDescontoRepositoryEloquent;
use Modules\Financeiro\Repositories\InformacaoBancariaRepository;
use Modules\Financeiro\Repositories\InformacaoBancariaRepositoryEloquent;
use Modules\Financeiro\Repositories\LancamentoFinanceiroRepository;
use Modules\Financeiro\Repositories\LancamentoFinanceiroRepositoryEloquent;
use Modules\Financeiro\Repositories\PlanoContaRepository;
use Modules\Financeiro\Repositories\PlanoContaRepositoryEloquent;
use Modules\Financeiro\Repositories\TransacaoRepository;
use Modules\Financeiro\Repositories\TransacaoRepositoryEloquent;
use Modules\Financeiro\Repositories\ContasPagarRepository;
use Modules\Financeiro\Repositories\ContasPagarRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ConfigGeralFinanceiroRepository::class,
            ConfigGeralFinanceiroRepositoryEloquent::class
        );
        $this->app->bind(
            PlanoContaRepository::class,
            PlanoContaRepositoryEloquent::class
        );
        $this->app->bind(
            CentroCustoRepository::class,
            CentroCustoRepositoryEloquent::class
        );
        $this->app->bind(
            CentroCustoRepository::class,
            CentroCustoRepositoryEloquent::class
        );
        $this->app->bind(
            LancamentoFinanceiroRepository::class,
            LancamentoFinanceiroRepositoryEloquent::class
        );
        $this->app->bind(
            ContaFinanceiroRepository::class,
            ContaFinanceiroRepositoryEloquent::class
        );
        $this->app->bind(
            ContasPagarRepository::class,
            ContasPagarRepositoryEloquent::class
        );
        $this->app->bind(
            InformacaoBancariaRepository::class,
            InformacaoBancariaRepositoryEloquent::class
        );
        $this->app->bind(
            TransacaoRepository::class,
            TransacaoRepositoryEloquent::class
        );
        $this->app->bind(
            CupomDescontoRepository::class,
            CupomDescontoRepositoryEloquent::class
        );
    }
}
