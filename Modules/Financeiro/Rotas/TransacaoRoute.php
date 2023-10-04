<?php

    namespace Modules\Financeiro\Rotas;

	//use Modules\Financeiro\Enuns\Rotina;
	use App\Interfaces\ICustomRoute;
    use \Route;

class TransacaoRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/financeiro","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
			Route::resource("transacao", "TransacaoController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);
		});
	}
}
