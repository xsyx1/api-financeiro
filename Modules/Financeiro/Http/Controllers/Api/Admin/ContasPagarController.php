<?php

namespace Modules\Financeiro\Http\Controllers\Api\Admin;

use Modules\Financeiro\Http\Requests\ParcelamentoRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;
use Illuminate\Http\Request;
use Modules\Financeiro\Criteria\ContasPagarCriteria;
use Modules\Financeiro\Http\Requests\AgruparRequest;
use Modules\Financeiro\Http\Requests\BaixaManualRequest;
use Modules\Financeiro\Http\Requests\ContasPagarRequest;
use Modules\Financeiro\Http\Requests\DesagruparRequest;
use Modules\Financeiro\Http\Requests\ParcelaAvulsaRequest;
use Modules\Financeiro\Services\ContasPagarService;
use Modules\Financeiro\Services\LancamentoFinanceiroService;

class ContasPagarController extends BaseController implements ICustomController
{
    public function __construct(
        private ContasPagarService $contasPagarService,
        private ContasPagarCriteria $contasPagarCriteria,
        private LancamentoFinanceiroService $lancamentofinanceiroService
    ) {
        parent::__construct($contasPagarService->getDefaultRepository(), $contasPagarCriteria);
    }

    public function getValidator($id = null)
    {
        return new ContasPagarRequest();
    }
    public function index(Request $request)
    {
        $paginacao = $request->get('totalitems', self::$paginationCount);
        if ($paginacao > 20) {
            $paginacao = 20;
        }
        return $this->contasPagarService->index($request, $paginacao);
    }
    public function store(ContasPagarRequest $request)
    {
        return $this->contasPagarService->create($request->getOnlyDataFields());
    }

    public function update(ContasPagarRequest $request, $id)
    {
        return $this->contasPagarService->update($request->getOnlyDataFields(), $id);
    }

    public function baixaManual(BaixaManualRequest $request)
    {
        return $this->contasPagarService->baixaManual($request->getOnlyDataFields());
    }
    public function parcelar(ParcelamentoRequest $request)
    {
        return $this->lancamentofinanceiroService->parcelar($request->getOnlyDataFields());
    }
    public function estorno(int $id)
    {
        return $this->contasPagarService->estorno($id);
    }
    public function agrupar(Request $request)
    {
        return $this->contasPagarService->agrupar($request->all());
    }
    public function desagrupar(Request $request)
    {
        return $this->contasPagarService->desagrupar($request->all());
    }
    public function substituicao(Request $request)
    {
        return $this->contasPagarService->substituicao(($request->all()));
    }

    public function listaFilhos(Request $request, $id){
        $paginacao = $request->get('totalitems', self::$paginationCount);
        if ($paginacao > 20) {
            $paginacao = 20;
        }
        return $this->contasPagarService->getFilhos($id, $paginacao, $request);
    }
    public function parcelaAvulsa(ParcelaAvulsaRequest $request) {
        return $this->contasPagarService->parcelaAvulsa($request->getOnlyDataFields());
    }
}
