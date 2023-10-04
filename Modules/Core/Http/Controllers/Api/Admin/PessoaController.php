<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Modules\Core\Services\PessoaService;
use App\Http\Controllers\BaseController;
use App\Traits\ResponseActions;

class PessoaController extends BaseController
{

	use ResponseActions;

	/**
	 * @var  PessoaService
	 */
	private $pessoaService;
	public function __construct(
		PessoaService $pessoaService)
	{
		$this->pessoaService=$pessoaService;
	}
	public function getValidator()
	{
		return null;
	}

	public function pesquisar_cpf_cnpj($query)
	{
		return $this->pessoaService->pesquisar_cpf_cnpj($query);
	}

}
