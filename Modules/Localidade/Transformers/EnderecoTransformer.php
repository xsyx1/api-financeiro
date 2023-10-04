<?php

namespace Modules\Localidade\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Localidade\Models\Endereco;

/**
 * Class EnderecoTransformer
 * @package namespace Modules\Localidade\Transformers;
 */
class EnderecoTransformer extends TransformerAbstract
{

	protected array $availableIncludes = ['bairro', 'cidade'];

	/**
	 * Transform the Endereco entity
	 * @param Endereco $model
	 *
	 * @return array
	 */
	public function transform(Endereco $model)
	{
		return [
			'id' => (int)$model->id,
			'bairro_id' => $model->bairro_id,
			'cidade_id' => $model->cidade_id,
			'estado_id' => $model->cidade->estado->id,
			'cidade_nome' => $model->cidade->nome,
			'logradouro' => (string)$model->logradouro,
			//'bairro_nome' => $model->bairro->nome,
			'estado_nome' => $model->cidade->estado->nome,
			'estado_uf' => $model->cidade->estado->uf,
			'cep' => (string)$model->cep,
			'complemento' => (string)$model->complemento,
			'numero' => (string)$model->numero,
			'tipo_endereco' => (string)$model->tipo_endereco,
			'pivot' => $model->pivot,
			'created_at' => $model->created_at,
			'updated_at' => $model->updated_at
		];
	}

	public function includeBairro(Endereco $model)
	{
		if (is_null($model->bairro)) {
			return null;
		}
		return $this->item($model->bairro, new BairroTransformer());
	}

	public function includeCidade(Endereco $model)
	{
		if (is_null($model->cidade)) {
			return null;
		}
		return $this->item($model->cidade, new CidadeTransformer());
	}
}
