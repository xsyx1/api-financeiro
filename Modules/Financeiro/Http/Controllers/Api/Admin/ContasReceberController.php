<?php

namespace Modules\Financeiro\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;
use Illuminate\Http\Request;
use Modules\Financeiro\Criteria\ContasReceberCriteria;
use Modules\Financeiro\Http\Requests\AgruparRequest;
use Modules\Financeiro\Http\Requests\BaixaManualRequest;
use Modules\Financeiro\Http\Requests\ContasReceberRequest;
use Modules\Financeiro\Http\Requests\DesagruparRequest;
use Modules\Financeiro\Http\Requests\ParcelaAvulsaRequest;
use Modules\Financeiro\Http\Requests\ParcelamentoRequest;
use Modules\Financeiro\Http\Requests\TransfLancamentoRequest;
use Modules\Financeiro\Services\ContasReceberService;
use Modules\Financeiro\Services\LancamentoFinanceiroService;

class ContasReceberController extends BaseController implements ICustomController
{

    /**
     * @var  ContasReceberCriteria
     */
    private $contasReceberCriteria;

    /**
     * @var ContasReceberService
     */
    private $contasReceberService;

    /**
     * @var  LancamentoFinanceiroService
     */
    private $lancamentofinanceiroService;

    public function __construct(
        ContasReceberService $contasReceberService,
        ContasReceberCriteria $contasReceberCriteria,
        LancamentoFinanceiroService $lancamentofinanceiroService
    ) {
        parent::__construct($contasReceberService->getDefaultRepository(), $contasReceberCriteria);
        $this->contasReceberCriteria = $contasReceberCriteria;
        $this->contasReceberService = $contasReceberService;
        $this->lancamentofinanceiroService = $lancamentofinanceiroService;
    }

    public function getValidator($id = null)
    {
        return new ContasReceberRequest();
    }
    public function index(Request $request)
    {
        $paginacao = $request->get('totalitems', self::$paginationCount);
        if ($paginacao > 20) {
            $paginacao = 20;
        }
        return $this->contasReceberService->index($request, $paginacao);
    }
    public function store(ContasReceberRequest $request)
    {
        return $this->contasReceberService->create($request->getOnlyDataFields());
    }

    public function update(ContasReceberRequest $request, $id)
    {
        return $this->contasReceberService->update($request->getOnlyDataFields(), $id);
    }

    public function baixaManual(BaixaManualRequest $request)
    {
        return $this->contasReceberService->baixaManual($request->getOnlyDataFields());
    }
    public function parcelar(ParcelamentoRequest $request)
    {
        return $this->lancamentofinanceiroService->parcelar($request->getOnlyDataFields());
    }
    public function estorno(int $id)
    {
        return $this->contasReceberService->estorno($id);
    }
    public function agrupar(Request $request)
    {
        return $this->contasReceberService->agrupar($request->all());
    }
    public function desagrupar(Request $request)
    {
        return $this->contasReceberService->desagrupar($request->all());
    }
    public function substituicao(Request $request)
    {
        return $this->contasReceberService->substituicao(($request->all()));
    }
    public function parcelaAvulsa(ParcelaAvulsaRequest $request) {
        return $this->contasReceberService->parcelaAvulsa($request->getOnlyDataFields());
    }
    public function listaFilhos(Request $request, $id){
        $paginacao = $request->get('totalitems', self::$paginationCount);
        if ($paginacao > 20) {
            $paginacao = 20;
        }
        return $this->contasReceberService->getFilhos($id, $paginacao, $request);
    }
}
