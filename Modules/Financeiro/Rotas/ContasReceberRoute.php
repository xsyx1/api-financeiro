<?php

namespace Modules\Financeiro\Rotas;

use App\Interfaces\ICustomRoute;
use Illuminate\Support\Facades\Route;

class ContasReceberRoute implements ICustomRoute
{
    public static function run()
    {
        Route::group(
            [
                "prefix" => "admin/financeiro",
                "middleware" => ["auth:api"],
                "namespace" => "Api\Admin"
            ],
            function () {
                Route::post('contasReceber/baixa', [
                    'as' => 'contasReceber.baixa',
                    'uses' => 'ContasReceberController@baixaManual'
                ]);
                Route::post('contasReceber/parcelar', [
                    'as' => 'contasReceber.parcelar',
                    'uses' => 'ContasReceberController@parcelar'
                ]);
                Route::post('contasReceber/estorno/{id}', [
                    'as' => 'contasReceber.estorno',
                    'uses' => 'ContasReceberController@estorno'
                ]);
                Route::post('contasReceber/agrupar', [
                    'as' => 'contasReceber.agrupar',
                    'uses' => 'ContasReceberController@agrupar'
                ]);
                Route::post('contasReceber/transferir/lancamento', [
                    'as' => 'contasReceber.transferir.lancamento',
                    'uses' => 'ContasReceberController@transfLancamento'
                ]);
                Route::post('contasReceber/desagrupar', [
                    'as' => 'contasReceber.desagrupar',
                    'uses' => 'ContasReceberController@desagrupar'
                ]);

                Route::resource("contasReceber", "ContasReceberController", [
                    "except" => ["create", "edit"]
                ]);
                Route::post('contasReceber/parcelaAvulsa/lancamento', [
                    'as' => 'contasReceber.parcelaAvulsa.lancamento',
                    'uses' => 'ContasReceberController@parcelaAvulsa'
                ]);
                Route::get('contasReceber/lista-filhos/{id}', [
                    'as' => 'contasReceber.lista-filhos',
                    'uses' => 'ContasReceberController@listaFilhos'
                ]);
            }
        );
        Route::group(
            [
                "prefix" => "system/financeiro",
                "middleware" => ["system.auth"],
                "namespace" => "Api\System"
            ],
            function () {
                Route::post('contasReceber/baixa', [
                    'as' => 'contasReceber.baixa',
                    'uses' => 'ContasReceberController@baixaManual'
                ]);
                Route::post('contasReceber/parcelar', [
                    'as' => 'contasReceber.parcelar',
                    'uses' => 'ContasReceberController@parcelar'
                ]);
                Route::post('contasReceber/estorno/{id}', [
                    'as' => 'contasReceber.estorno',
                    'uses' => 'ContasReceberController@estorno'
                ]);
                Route::post('contasReceber/agrupar', [
                    'as' => 'contasReceber.agrupar',
                    'uses' => 'ContasReceberController@agrupar'
                ]);
                Route::post('contasReceber/transferir/lancamento', [
                    'as' => 'contasReceber.transferir.lancamento',
                    'uses' => 'ContasReceberController@transfLancamento'
                ]);
                Route::post('contasReceber/desagrupar', [
                    'as' => 'contasReceber.desagrupar',
                    'uses' => 'ContasReceberController@desagrupar'
                ]);

                Route::resource("contasReceber", "ContasReceberController", [
                    "except" => ["create", "edit"]
                ]);
                Route::post('contasReceber/parcelaAvulsa/lancamento', [
                    'as' => 'contasReceber.parcelaAvulsa.lancamento',
                    'uses' => 'ContasReceberController@parcelaAvulsa'
                ]);
                Route::get('contasReceber/lista-filhos/{id}', [
                    'as' => 'contasReceber.lista-filhos',
                    'uses' => 'ContasReceberController@listaFilhos'
                ]);
            }
        );
    }
}
