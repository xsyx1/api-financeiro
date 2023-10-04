<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 30/07/2018
 * Time: 09:44
 */

namespace Modules\Localidade\Services;


use Modules\Core\Models\Pessoa;
use Modules\Localidade\Models\Endereco;
use App\Services\BaseService;

class EnderecoService extends BaseService
{

	public function create(&$model, $data)
	{
		array_map(function ($item) use (&$model) {
			$endereco = new Endereco();
			$endereco->logradouro = isset_or_null_response($item, 'logradouro');
			$endereco->cep = $item['cep'];
			$endereco->complemento = isset_or_null_response($item, 'complemento');
			$endereco->numero = isset_or_null_response($item, 'numero');
			$endereco->tipo_endereco = isset_or_null_response($item, 'tipo_endereco');
			$endereco->cidade_id = (isset($item['cidade']['id'])) ? $item['cidade']['id'] : $item['cidade_id'];
			if (is_null(isset_or_null_response($item, 'bairro_id'))) {
				if(isset($item['bairro']['nome'])){
					$bairro = $endereco->bairro()->create([
						'nome' => $item['bairro']['nome'],
						'cidade_id' => $item['cidade']['id']
					]);
					$endereco->bairro_id = $bairro->id;
				}
			} else {
				$endereco->bairro_id = $item['bairro_id'];
			}
			$endereco->save();
			$model->enderecos()->save($endereco);
		}, $data);
	}

	public function update(&$model, $data)
	{
		array_map(function ($item) use (&$model) {
			$model->enderecos->logradouro = isset_or_null_response($item, 'logradouro');
			$model->enderecos->cep = $item['cep'];
			$model->enderecos->complemento = isset_or_null_response($item, 'complemento');
			$model->enderecos->numero = isset_or_null_response($item, 'numero');
			$model->enderecos->tipo_endereco = isset_or_null_response($item, 'tipo_endereco');
			$model->enderecos->cidade_id = (isset($item['cidade']['id'])) ? $item['cidade']['id'] : $item['cidade_id'];
			if (is_null(isset_or_null_response($item, 'bairro_id'))) {
				if(isset($item['bairro']['nome'])) {
					$bairro = $model->enderecos->bairro()->create([
						'nome' => $item['bairro']['nome'],
						'cidade_id' => $item['cidade']['id']
					]);
					$model->enderecos->bairro_id = $bairro->id;
				}
			} else {
				$model->enderecos->bairro_id = $item['bairro']['id'];
			}
			$model->enderecos->save();
		}, $data);
	}

	public static function salvarEndereco($data, &$filial){
		array_map(function ($item) use (&$filial) {
			if(!isset($item['id'])){
				$endereco = new Endereco();
				$endereco->logradouro = isset_or_null_response($item, 'logradouro');
				$endereco->cep = $item['cep'];
				$endereco->complemento = isset_or_null_response($item, 'complemento');
				$endereco->numero = isset_or_null_response($item, 'numero');
				$endereco->tipo_endereco = isset_or_null_response($item, 'tipo_endereco');
				$endereco->cidade_id = (isset($item['cidade']['id'])) ? $item['cidade']['id'] : $item['cidade_id'];
				if (is_null(isset_or_null_response($item, 'bairro_id'))) {
					if(isset($item['bairro']['nome'])){
						$bairro = $endereco->bairro()->create([
							'nome' => $item['bairro']['nome'],
							'cidade_id' => $item['cidade']['id']
						]);
						$endereco->bairro_id = $bairro->id;
					}
				} else {
					$endereco->bairro_id = $item['bairro_id'];
				}
				$endereco->save();
				$filial->pessoa->enderecos()->save($endereco);
			}else{
				$endereco = $filial->pessoa->enderecos->where('id', $item['id'])->first();
				$endereco->fill($item)->save();
			}
		}, $data['pessoa']['enderecos']);
	}

	public static function salvarEnderecoSemPessoa($data, &$filial){
		array_map(function ($item) use (&$filial) {
			if(!isset($item['id'])){
				$endereco = new Endereco();
				$endereco->logradouro = isset_or_null_response($item, 'logradouro');
				if(isset($item['cep']))
					$endereco->cep = $item['cep'];
				$endereco->complemento = isset_or_null_response($item, 'complemento');
				$endereco->numero = isset_or_null_response($item, 'numero');
				$endereco->tipo_endereco = isset_or_null_response($item, 'tipo_endereco');
				$endereco->cidade_id = (isset($item['cidade']['id'])) ? $item['cidade']['id'] : $item['cidade_id'];
				if (is_null(isset_or_null_response($item, 'bairro_id'))) {
					if(isset($item['bairro']['nome'])){
						$bairro = $endereco->bairro()->create([
							'nome' => $item['bairro']['nome'],
							'cidade_id' => $item['cidade']['id']
						]);
						$endereco->bairro_id = $bairro->id;
					}
				} else {
					$endereco->bairro_id = $item['bairro_id'];
				}
				$endereco->save();
				$filial->enderecos()->save($endereco);
			}else{
				$endereco = $filial->enderecos->where('id', $item['id'])->first();
				$endereco->fill($item)->save();
			}
		}, $data['enderecos']);
	}
}
