<?php

namespace Modules\Core\Transformers;

use Modules\Core\Models\Pessoa;
use Modules\Financeiro\Transformers\ClienteTransformer;
use App\Transformers\BaseTransformer;
use Modules\Localidade\Transformers\EnderecoTransformer;
use Modules\Localidade\Transformers\TelefoneTransformer;

/**
 * Class PessoaTransformer
 * @package namespace App\Transformers;
 */
class PessoaTransformer extends BaseTransformer
{

	protected array $availableIncludes = ['clientes', 'enderecos', 'telefones'];

	public function transform(Pessoa $model)
	{
		return $this->removeNull([
			'id' => (int)$model->id,
			'nome' => (string) $model->nome,
			'email' => (string)$model->email,
			'cpf_cnpj' => (string)$model->cpf_cnpj,
			'estado_civil' => $model->estado_civil,
			'regime_uniao' => $model->regime_uniao,
			'data_nascimento' => $model->data_nascimento,
			'sexo' => $model->sexo,
			'rg' => $model->rg,
			'filiacao_mae' => $model->filiacao_mae,
			'razao_social' => $model->razao_social,
			'inscricao_municipal' => $model->inscricao_municipal,
			'inscricao_estadual' => $model->inscricao_estadual,
			'data_fundacao' => $model->data_fundacao,
			'descricao' => (string)$model->descricao,
			'created_at' => $model->created_at,
			'updated_at' => $model->updated_at,
			'filiacao_pai' => (string) $model->filiacao_pai,
			'cliente_id' => $model->cliente_id
		]);
	}

	public function includeClientes(Pessoa $model)
	{
		if (is_null($model->clientes)) {
			return null;
		}
		return $this->collection($model->clientes, new ClienteTransformer());
	}
	public function includeEnderecos(Pessoa $model)
	{
		if ($model->enderecos->count() == 0) {
			return null;
		}
		return $this->collection($model->enderecos, new EnderecoTransformer());
	}

	public function includeTelefones(Pessoa $model)
	{
		if (is_null($model->telefones)) {
			return null;
		}
		return $this->collection($model->telefones, new TelefoneTransformer());
	}
}
