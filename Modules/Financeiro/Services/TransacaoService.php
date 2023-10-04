<?php

namespace Modules\Financeiro\Services;

use Modules\Financeiro\Repositories\TransacaoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class TransacaoService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  TransacaoRepository
	 */
	private $transacaoRepository;

	public function __construct(TransacaoRepository $transacaoRepository)
	{
		$this->transacaoRepository = $transacaoRepository;
	}

	public function getDefaultRepository()
	{
		return $this->transacaoRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

	}
}
