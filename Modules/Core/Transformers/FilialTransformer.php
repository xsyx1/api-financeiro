<?php


namespace Modules\Core\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Core\Models\Filial;

/**
 * Class GrupoTransformer
 * @package namespace App\Transformers;
 */
class FilialTransformer extends TransformerAbstract
{

	protected array $availableIncludes = ['pessoa', 'filhos', 'pai'];

	/**
	 * Transform the Filial entity
	 * @param Filial $model
	 *
	 * @return array
	 */
	public function transform(Filial $model)
	{
		return [
			'id'         => (int) $model->id,
			'pessoa_id' => (int) $model->pessoa_id,
			'nome_conta' => (string) $model->nome_conta,
			'valor_repasse' => (float) $model->valor_repasse,
			'valor_acrescimo' => (float) $model->valor_acrescimo,
			'cobra_convenio' => (bool) $model->cobra_convenio,
			'cobra_particular' => (bool) $model->cobra_particular,
			'dia_repasse' =>  $model->dia_repasse,
			'convenios' =>  $model->convenios,
			'dia_recebimento_cartao' => (int) $model->dia_recebimento_cartao,
			"nome_filial" => $model->pessoa->nome,
			"email_filial" => $model->pessoa->email,
			"parent_id" => (int)$model->parent_id,
			'tipo_parceria' => $model->tipo_parceria,
			'percentual_medbrasil' => $model->percentual_medbrasil,
			'percentual_parceria' => $model->percentual_parceria,
			'percentual_clinica' => $model->percentual_clinica,
			'percentual_medico' => $model->percentual_medico,
			'recipient_id' => $model->recipient_id,
		];
	}

	public function includePessoa(Filial $model)
	{
		if (is_null($model->pessoa)) {
			return null;
		}
		return $this->item($model->pessoa, new PessoaTransformer());
	}

	public function includeFilhos(Filial $model)
	{
		if ($model->filhos->count() == 0) {
			return $this->null();
		}
		return $this->collection($model->filhos, new FilialTransformer());
	}

	public function includePai(Filial $model)
	{
		if ($model->pai->count() == 0) {
			return $this->null();
		}
		return $this->collection($model->pai, new FilialTransformer());
	}
}
