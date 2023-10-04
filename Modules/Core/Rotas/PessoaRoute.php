<?php

namespace Modules\Core\Rotas;

use App\Interfaces\ICustomRoute;
use Illuminate\Support\Facades\Route;

class PessoaRoute implements ICustomRoute
{
    public static function run()
    {
        Route::group(['prefix' => 'admin/core', 'middleware' => ['auth:api'], 'namespace' => 'Api\Admin'], function () {
            Route::get('pessoa/pesquisar-cpf-cnpj/{query}', [
                'as' => 'core.pessoa.pesquisar_cpf_cnpj',
                'uses' => 'PessoaController@pesquisar_cpf_cnpj'
            ]);
        });
    }
}
