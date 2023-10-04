<?php


namespace Modules\Financeiro\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Transformers\AnexoTransformer;
use Modules\Core\Transformers\PessoaTransformer;
use Modules\Financeiro\Models\Cliente;

/**
 * Class ClienteTransformer
 * @package  namespace Modules\Financeiro\Transformers;
 */
class ClienteTransformer extends TransformerAbstract
{

	protected array $availableIncludes = ['pessoa'];

	/**
	 * Transform the ClienteTransformer entity
	 * @param  Cliente $model
	 *
	 * @return  array
	 */
	public function transform(Cliente $model)
	{
		return [
			'id' => (int)$model->id,
			'status' => (bool)$model->status,
			"nome_cliente" => $model->pessoa->nome,
			"email_cliente" => $model->pessoa->email,
			"customer_id" => $model->customer_id,
			"api_gateway" => $model->api_gateway,
		];
	}

	public function includePessoa(Cliente $model)
	{
		if (is_null($model->pessoa)) {
			return null;
		}
		return $this->item($model->pessoa, new PessoaTransformer());
	}
	
}
