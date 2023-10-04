<?php

namespace Modules\Financeiro\Http\Controllers\Api\Admin;

use Modules\Financeiro\Criteria\ConfigGeralFinanceiroCriteria;
use Modules\Financeiro\Services\ConfigGeralFinanceiroService;
use Modules\Financeiro\Http\Requests\ConfigGeralFinanceiroRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class ConfigGeralFinanceiroController extends BaseController implements ICustomController
{

	/**
	 * @var  ConfigGeralFinanceiroCriteria
	 */
	private $configgeralfinanceiroCriteria;

	/**
	 * @var  ConfigGeralFinanceiroService
	 */
	private $configgeralfinanceiroService;

	public function __construct(ConfigGeralFinanceiroService $configgeralfinanceiroService, ConfigGeralFinanceiroCriteria $configgeralfinanceiroCriteria)
	{
		parent::__construct($configgeralfinanceiroService->getDefaultRepository(), $configgeralfinanceiroCriteria);
		$this->configgeralfinanceiroCriteria = $configgeralfinanceiroCriteria;
		$this->configgeralfinanceiroService = $configgeralfinanceiroService;
	}

	public function getValidator($id = null)
	{
		return (new ConfigGeralFinanceiroRequest())->rules($id);
	}

	public function configuracao(){
		return $this->configgeralfinanceiroService->configuracao();
	}

	public function updateConfiguracao(ConfigGeralFinanceiroRequest $configGeralFinanceiroRequest){
		return $this->configgeralfinanceiroService->updateConfiguracao($configGeralFinanceiroRequest->getOnlyDataFields());
	}


}

