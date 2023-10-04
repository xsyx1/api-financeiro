<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 16:08
 */

namespace Modules\Localidade\Rotas;

use App\Interfaces\ICustomRoute,
    \Route;

class LocalidadeRoute implements ICustomRoute
{

    public static function run()
    {
		Route::group(['prefix'=>'admin','namespace'=>'Api\Admin'],function () {
			Route::get('localidade/cidades/select-cidades-pesquisa/{estadoId}', [
				'as' => 'localidade.select-cidades-pesquisa',
				'uses' => 'LocalidadeController@selectCidadesPesquisa'
			]);
			Route::get('localidade/cidades/select-cidades/{estadoId}', [
				'as' => 'localidade.select-cidades',
				'uses' => 'LocalidadeController@selectCidades'
			]);
			Route::get('localidade/cidades/pesquisa-cidade/{estadoId}/{cidade}', [
				'as' => 'localidade.select-cidade-por-texto',
				'uses' => 'LocalidadeController@selectCidadeByTexto'
			]);

			Route::get('localidade/bairro/pesquisa-bairro/{cidadeId}/{bairro}', [
				'as' => 'localidade.select-bairros-por-pesquisa',
				'uses' => 'LocalidadeController@selectBairrosByPesquisa'
			]);

			Route::get('localidade/estados/select-estados', [
				'as' => 'localidade.select-estados',
				'uses' => 'LocalidadeController@selectEstados'
			]);
		});
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){
            /*Route::get('localidade/cidades/select-cidades/{estadoId}', [
                'as' => 'localidade.consulta_cidades',
                'uses' => 'LocalidadeController@selectCidades'
            ]);
			Route::get('localidade/estados/select-estados', [
				'as' => 'localidade.consulta_estaos',
				'uses' => 'LocalidadeController@selectEstados'
			]);*/
            Route::get('localidade/bairro/select-bairros/{cidadeId}', [
                'as' => 'localidade.select-bairros',
                'uses' => 'LocalidadeController@selectBairros'
            ]);
            Route::get('localidade/geo-localizacao/{cidade}/{endereco}/{estado}', [
                'as' => 'localidade.consulta_geo_localizacao',
                'uses' => 'LocalidadeController@getSinglePosition'
            ]);
			Route::get('localidade/cep-localidade/{cep}', [
				'as' => 'localidade.por-cep',
				'uses' => 'LocalidadeController@localidadeByCep'
			]);
            Route::get('localidade/cidades/pesquisar/{query}',[
                'as' => 'localidade.pesquisar-cidade.no_context_md',
                'uses' => 'LocalidadeController@pesquisarCidade'
            ]);
        });
        Route::group(['prefix'=>'front','namespace'=>'Api\Front'],function (){
            Route::get('localidade/cidades/select-cidades/{estadoId}', [
                'as' => 'localidade.select-cidades.no_context_md',
                'uses' => 'LocalidadeController@selectCidades'
            ]);
            Route::get('localidade/bairro/select-bairros/{cidadeId}', [
                'as' => 'localidade.select-bairros',
                'uses' => 'LocalidadeController@selectBairros'
            ]);
            Route::get('localidade/estados/select-estados', [
                'as' => 'localidade.select-estados.no_context_md',
                'uses' => 'LocalidadeController@selectEstados'
            ]);
            Route::get('localidade/cep-localidade/{cep}', [
                'as' => 'localidade.por-cep.no_context_md',
                'uses' => 'LocalidadeController@localidadeByCep'
            ]);
            Route::get('localidade/cep-localidade/{lat}/{lng}', [
                'as' => 'localidade.por-geo',
                'uses' => 'LocalidadeController@localidadeGeo'
            ]);
            Route::get('localidade/cidades/pesquisar/{query}',[
                'as' => 'localidade.pesquisar-cidade.no_context_md',
                'uses' => 'LocalidadeController@pesquisarCidade'
            ]);
        });
    }
}