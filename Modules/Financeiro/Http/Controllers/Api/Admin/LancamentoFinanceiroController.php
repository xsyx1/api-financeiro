<?php

namespace Modules\Financeiro\Http\Controllers\Api\Admin;

use Modules\Financeiro\Criteria\LancamentoFinanceiroCriteria;
use Modules\Financeiro\Enuns\Banco;
use Modules\Financeiro\Http\Requests\LancamentoFinanceiroAgruparRequestRequest;
use Modules\Financeiro\Http\Requests\PagamentoRequest;
use Modules\Financeiro\Http\Requests\ParcelamentoRequest;
use Modules\Financeiro\Services\LancamentoFinanceiroService;
use Modules\Financeiro\Http\Requests\LancamentoFinanceiroRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LancamentoFinanceiroController extends BaseController implements ICustomController
{
	public function __construct(private LancamentoFinanceiroService $lancamentofinanceiroService, private LancamentoFinanceiroCriteria $lancamentofinanceiroCriteria)
	{
		parent::__construct($lancamentofinanceiroService->getDefaultRepository(), $lancamentofinanceiroCriteria);
	}

	public function getValidator($id = null)
	{
		return new LancamentoFinanceiroRequest();
	}

	public function index(Request $request)
    {
        $paginacao = $request->get('totalitems', self::$paginationCount);
        if ($paginacao > 20) {
            $paginacao = 20;
        }
        return $this->lancamentofinanceiroService->index($request, $paginacao);
    }

	public function store(LancamentoFinanceiroRequest $request)
	{
		// return $this->lancamentofinanceiroService->create($request->getOnlyDataFields());
	}

    public function listaFilhos($id){
        return $this->lancamentofinanceiroService->getFilhos($id);
    }
}

