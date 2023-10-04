<?php

namespace Modules\Financeiro\Rotas;

use App\Interfaces\ICustomRoute;
use \Route;

class PlanoContaRoute implements ICustomRoute
{
    public static function run()
    {

        Route::group(["prefix" => "admin/financeiro", "middleware" => ["auth:api"], "namespace" => "Api\Admin"], function () {
            Route::get('planoconta/pegar-filhos/{id}', [
                'as' => 'planoconta.pegar-filhos',
                'uses' => 'PlanoContaController@getFilhos',
            ]);
            Route::resource(
                "planoconta",
                "PlanoContaController",
                [
                    //"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
                    "except" => ["create", "edit"]
                ]
            );
        });
    }
}
