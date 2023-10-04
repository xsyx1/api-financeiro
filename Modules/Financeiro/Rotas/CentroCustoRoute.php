<?php

    namespace Modules\Financeiro\Rotas;

	//use Modules\Financeiro\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class CentroCustoRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/financeiro","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
			Route::get('centrocusto/pegar-filhos/{id}',[
				'as'=>'centro_custo.pegar-filhos',
				'uses' => 'CentroCustoController@getFilhos',
			]);
			Route::resource("centrocusto", "CentroCustoController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});
	}
}
