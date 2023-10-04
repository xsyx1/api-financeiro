<?php

namespace Modules\Core\Rotas;

use App\Interfaces\ICustomRoute;
use Illuminate\Support\Facades\Route;

class FilialRoute implements ICustomRoute
{
	public static function run()
	{
		Route::group(["prefix" => "admin/core", "middleware" => ["auth:api"], "namespace" => "Api\Admin"], function () {
			Route::get('filial/pesquisar/{query}', [
				'as' => 'saude.filial.pesquisar',
				'uses' => 'FilialController@pesquisar'
			]);
			Route::resource(
				"filial",
				"FilialController",
				[
					"except" => ["create", "edit"]
				]
			);
			Route::get('select-filais', [
				'as' => 'saude.filial.listafiliais',
				'uses' => 'FilialController@filiaisSelect'
			]);
		});
	}
}
