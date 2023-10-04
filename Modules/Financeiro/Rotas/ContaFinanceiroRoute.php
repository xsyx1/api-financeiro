<?php

    namespace Modules\Financeiro\Rotas;

	//use Modules\Financeiro\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
use Illuminate\Support\Facades\Route;

class ContaFinanceiroRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/financeiro","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
			Route::resource("contafinanceiro", "ContaFinanceiroController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});
	}
}
