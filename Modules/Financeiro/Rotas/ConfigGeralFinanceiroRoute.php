<?php

    namespace Modules\Financeiro\Rotas;
	use App\Interfaces\ICustomRoute;
    use \Route;

class ConfigGeralFinanceiroRoute implements ICustomRoute
{
    public static function run()
    {
		Route::group(["prefix"=>"admin/financeiro","middleware" => ["auth:api"],"namespace"=>"Api\Admin"],function () {
			Route::get("configuracao-geral", [
				'as' => 'user.configuracao',
				'uses' => 'ConfigGeralFinanceiroController@configuracao',
			]);
			Route::put("configuracao-geral", [
				'as' => 'user.configuracao',
				'uses' => 'ConfigGeralFinanceiroController@updateConfiguracao',
			]);
			/*Route::resource("configgeralfinanceiro", "ConfigGeralFinanceiroController",
				[
					//"middleware" => [Rotina::middlewareForm("possuiRotina", Rotina::GERENCIAR_PROFISSIONAL_SAUDE)],
					"except" => ["create", "edit"]
				]);*/
		});
	}
}
