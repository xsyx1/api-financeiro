<?php

namespace Modules\Financeiro\Services;

use Modules\Financeiro\Repositories\CupomDescontoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class CupomDescontoService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  CupomDescontoRepository
	 */
	private $cupomDescontoRepository;

	public function __construct(CupomDescontoRepository $cupomDescontoRepository)
	{
		$this->cupomDescontoRepository = $cupomDescontoRepository;
	}

	public function getDefaultRepository()
	{
		return $this->cupomDescontoRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);
	}
}
