<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    \Modules\Financeiro\Rotas\ConfigGeralFinanceiroRoute::run();
    \Modules\Financeiro\Rotas\PlanoContaRoute::run();
    \Modules\Financeiro\Rotas\CentroCustoRoute::run();
    \Modules\Financeiro\Rotas\LancamentoFinanceiroRoute::run();
    \Modules\Financeiro\Rotas\ContasPagarRoute::run();
    \Modules\Financeiro\Rotas\ContasReceberRoute::run();
    \Modules\Financeiro\Rotas\ContaFinanceiroRoute::run();
    \Modules\Financeiro\Rotas\TransacaoRoute::run();
});
