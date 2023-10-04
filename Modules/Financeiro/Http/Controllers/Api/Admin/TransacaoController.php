<?php

namespace Modules\Financeiro\Http\Controllers\Api\Admin;

use Modules\Financeiro\Criteria\TransacaoCriteria;
use Modules\Financeiro\Services\TransacaoService;
use Modules\Financeiro\Http\Requests\TransacaoRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class TransacaoController extends BaseController implements ICustomController
{

	/**
	 * @var  TransacaoCriteria
	 */
	private $transacaoCriteria;

	/**
	 * @var  TransacaoService
	 */
	private $transacaoService;

	public function __construct(TransacaoService $transacaoService, TransacaoCriteria $transacaoCriteria)
	{
		parent::__construct($transacaoService->getDefaultRepository(), $transacaoCriteria);
		$this->transacaoCriteria = $transacaoCriteria;
		$this->transacaoService = $transacaoService;
	}

	public function getValidator()
	{
		return new TransacaoRequest();
	}


}

