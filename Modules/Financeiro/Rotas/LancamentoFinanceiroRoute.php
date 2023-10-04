<?php

namespace Modules\Financeiro\Rotas;

//use Modules\Financeiro\Enuns\Rotina;
use App\Interfaces\ICustomRoute;
use Illuminate\Support\Facades\Route;

class LancamentoFinanceiroRoute implements ICustomRoute
{
    public static function run()
    {
        Route::group(["prefix" => "admin/financeiro", "middleware" => ["auth:api"], "namespace" => "Api\Admin"], function () {
            Route::get('lancamentofinanceiro/lista-filhos/{id}', [
                'as' => 'financeiro.lista-filhos',
                'uses' => 'LancamentoFinanceiroController@listaFilhos'
            ]);
            Route::get('lancamentofinanceiro', [
                'as' => 'financeiro.index',
                'uses' => 'LancamentoFinanceiroController@index'
            ]);
            Route::resource(
                "lancamentofinanceiro",
                "LancamentoFinanceiroController",
                [
                    "except" => ["create", "index", "edit"]
                ]
            );
        });
    }
}
