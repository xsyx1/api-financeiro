<?php

    namespace Modules\Financeiro\Rotas;

	//use Modules\Financeiro\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
use Illuminate\Support\Facades\Route;

class ContasPagarRoute implements ICustomRoute
{
    public static function run()
    {
        Route::group(["prefix"=>"admin/financeiro","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
            Route::post('contasPagar/baixa', [
                'as' => 'contasPagar.baixa',
                'uses' => 'ContasPagarController@baixaManual'
            ]);
            Route::post('contasPagar/parcelar', [
                'as' => 'contasPagar.parcelar',
                'uses' => 'ContasPagarController@parcelar'
            ]);
            Route::post('contasPagar/estorno/{id}', [
				'as' => 'contasPagar.estorno',
				'uses' => 'ContasPagarController@estorno'
			]);
            Route::post('contasPagar/agrupar', [
				'as' => 'contasPagar.agrupar',
				'uses' => 'ContasPagarController@agrupar'
			]);
            Route::post('contasPagar/substituicao', [
				'as' => 'contasPagar.substituicao',
				'uses' => 'ContasPagarController@substituicao'
			]);
			Route::post('contasPagar/desagrupar', [
				'as' => 'contasPagar.desagrupar',
				'uses' => 'ContasPagarController@desagrupar'
			]);
			Route::post('contasPagar/parcelaAvulsa/lancamento', [
				'as' => 'contasPagar.parcelaAvulsa.lancamento',
				'uses' => 'ContasPagarController@parcelaAvulsa'
			]);
			Route::resource("contasPagar", "ContasPagarController", [
				"except" => ["create", "edit"]
			]);
			Route::get('contasPagar/lista-filhos/{id}', [
                'as' => 'contasPagar.lista-filhos',
                'uses' => 'ContasPagarController@listaFilhos'
            ]);
		});
	}
}
