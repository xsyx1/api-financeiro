<?php


namespace Modules\Financeiro\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Financeiro\Enuns\TipoPlanoConta;
use Modules\Financeiro\Models\PlanoConta;

/**
 * Class PlanoContaTransformer
 * @package  namespace Modules\Financeiro\Transformers;
 */
class PlanoContaTransformer extends TransformerAbstract
{
    protected array $availableIncludes = ['filhos'];

    public function transform(PlanoConta $model)
	{
		return [
			'id' => (int)$model->id,
            'parent_id' => $model->parent_id,
			'nome' => (string)$model->nome,
			'cor' => (string)$model->cor,
			'status' => (bool)$model->status,
			'status_label' => $model->status ? 'Ativo' : 'Inativo',
			'tipo' => (int)$model->tipo,
			'tipo_label' => (new TipoPlanoConta($model->tipo))->toArray(),
			'recebe_lancamento' => (bool)$model->recebe_lancamento,
			'contabil' => (bool)$model->contabil,
			'filhos_count' => (int)$model->filhos->count(),
			'codigo' => (string)$model->codigo,
		];
	}

    public function includeFilhos(PlanoConta $model){
        if($model->filhos->count() == 0){
            return $this->null();
        }
        return $this->collection($model->filhos, new PlanoContaTransformer());
    }

}
