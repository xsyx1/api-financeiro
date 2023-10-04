<?php

namespace Modules\Localidade\Services;

use Modules\Localidade\Repositories\BairroRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class BairroService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  BairroRepository
	 */
	private $bairroRepository;

	public function __construct(BairroRepository $bairroRepository)
	{
		$this->bairroRepository = $bairroRepository;
	}

	public function getDefaultRepository()
	{
		return $this->bairroRepository;
	}

	public function pesquisar($cidadeId, $bairro){
		return $this->getDefaultRepository()->scopeQuery(function ($query) use ($bairro){
			return $query->where('nome', 'ilike', "%".$bairro."%");
		})->findWhere(['cidade_id' => $cidadeId]);
	}
}
