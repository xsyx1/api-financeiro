<?php

namespace Modules\Core\Transformers;

use Modules\Core\Enuns\StatusUser;
use Modules\Core\Models\User;
use Modules\Core\Services\AuthService;
use Modules\Esterilizacao\Transformers\OperadorTransformer;
use Modules\Esterilizacao\Transformers\RequerenteTransformer;
use Modules\Saude\Transformers\AtendenteTransformer;
use Modules\Saude\Transformers\BeneficiarioTransformer;
use Modules\Saude\Transformers\PrestadorServicoTransformer;
use Modules\Saude\Transformers\RepresentanteTransformer;
use App\Transformers\BaseTransformer;

/**
 * Class UserTransformer
 * @package namespace Modules\Core\Transformers;
 */
class UserTransformer extends BaseTransformer
{

	protected array $availableIncludes = [
		'filiais',	
	];

	/**
	 * Transform the \User entity
	 * @param \User $model
	 *
	 * @return array
	 */
	public function transform(User $model)
	{
		$result = [
			'id' => (int)$model->id,
			'username' => (string)$model->username,
			'email' => (string)$model->email,
			'img' => $model->img,
			'cpf' => (string)$model->cpf,
			'nome' => (string)$model->nome,
			'status' => (int)$model->status,
			'is_admin' => (bool)$model->is_admin,
			'status_enum' => (new StatusUser($model->status))->toArray(),
			'acesso_filhos' => $model->acesso_filhos,
			"client_id" => AuthService::getClient()->id,
		];

		return self::removeNull($result);
	}

	public function includeFiliais(User $model)
	{
		if (is_null($model->filiais)) {
			return null;
		}
		return $this->collection($model->filiais, new FilialTransformer());
	}
}
