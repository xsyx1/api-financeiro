<?php

namespace Modules\Financeiro\Services;

use Modules\Financeiro\Repositories\InformacaoBancariaRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class InformacaoBancariaService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  InformacaoBancariaRepository
	 */
	private $informacaobancariaRepository;

	public function __construct(InformacaoBancariaRepository $informacaobancariaRepository)
	{
		$this->informacaobancariaRepository = $informacaobancariaRepository;
	}

	public function getDefaultRepository()
	{
		return $this->informacaobancariaRepository;
	}
}
