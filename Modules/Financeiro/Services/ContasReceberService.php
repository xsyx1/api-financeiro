<?php

namespace Modules\Financeiro\Services;

use App\Criteria\OrderCriteria;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\HandleTryCatch;
use App\Traits\ResponseActions;
use Illuminate\Http\JsonResponse;
use Modules\Core\Services\AuthService;
use Modules\Financeiro\Criteria\ContasReceberCriteria;
use Modules\Financeiro\Enuns\DescHistoricoEnum;
use Modules\Financeiro\Enuns\HistoricoSituacao;
use Modules\Financeiro\Enuns\SituacaoPagamento;
use Modules\Financeiro\Enuns\TipoLancamento;
use Modules\Financeiro\Enuns\TipoParcela;
use Modules\Financeiro\Models\LancamentoFinanceiro;
use Modules\Financeiro\Presenters\ContasReceberPresenter;
use Modules\Financeiro\Repositories\LancamentoFinanceiroRepository;

class ContasReceberService extends BaseService implements IService
{
    use ResponseActions, HandleTryCatch;

    /**
     * @var  LancamentoFinanceiroService
     */
    private $lancamentofinanceiroService;

    /**
     * @var  LancamentoFinanceiroRepository
     */
    private $lancamentofinanceiroRepository;

    public function __construct(
        LancamentoFinanceiroRepository $lancamentofinanceiroRepository,
        LancamentoFinanceiroService $lancamentofinanceiroService
    ) {
        $this->lancamentofinanceiroService = $lancamentofinanceiroService;
        $this->lancamentofinanceiroRepository = $lancamentofinanceiroRepository;
    }

    public function getDefaultRepository()
    {
        return $this->lancamentofinanceiroRepository;
    }

    public function index($request, $paginacao)
    {
        return $this->handleTryCatch(function () use ($request, $paginacao) {
            $lancamento = $this->getDefaultRepository()
                ->pushCriteria(new ContasReceberCriteria($request))
                ->pushCriteria(new OrderCriteria($request))
                ->skipPresenter(true)
                ->paginate($paginacao);

            return self::transformerData($lancamento, ContasReceberPresenter::class);
        }, false);
    }

    public function create(array $data): mixed
    {
        return $this->handleTryCatch(function () use ($data) {
            $data['data_emissao'] ??= date('Y-m-d h:i:s');
            $data['saldo'] = $data['valor_original'];
            $data['tipo_parcela'] = TipoParcela::AVULSO;
            $data['situacao_pagamento'] = SituacaoPagamento::ABERTO;
            $data['usuario_id'] = AuthService::getUserId();
            $data['historico'] = $this->lancamentofinanceiroService->descBaixa(null, DescHistoricoEnum::CRIADO);
            if (isset($data['centro_custo'])) {
                $centro = $data['centro_custo'];
                unset($data['centro_custo']);
            }
            $data['filial_id'] = $data['filial_id'] ?? null;
            $retorno = $this->getDefaultRepository()->skipPresenter(true)->create($data);
            $num_parcela = ($data['num_parcela'] > 1) ? $data['num_parcela'] : '01';
            $total_parcela = ($data['num_parcela'] > 1) ? $data['num_parcela'] : '001';
            $numero_documento = $retorno->venda_id ? $retorno->venda_id : $retorno->id;
            $retorno->numero_documento = $numero_documento . '/' . $num_parcela . '-' . $total_parcela;
            $retorno->save();
            if (isset($centro)) {
                $retorno->centro_pivot()->attach($centro);
            }
            if ($data['num_parcela'] > 1) {
                $data['total_parcelas'] = $data['num_parcela'];
                unset($data['num_parcela']);
                $retorno = $this->lancamentofinanceiroService
                    ->parcelar(['lancamento_id' => $retorno->id, 'content' => $data]);
            }
            if ($retorno instanceof JsonResponse) {
                return self::responseError(
                    self::$HTTP_CODE_NOT_FOUND,
                    null,
                    $retorno->original['error']['message'],
                    $retorno->original['error']['arquivo'],
                    $retorno->original['error']['linha'],
                );
            }
            return self::transformerData($retorno, ContasReceberPresenter::class);
        }, true);
    }

    public function baixaManual(array $data)
    {
        return $this->handleTryCatch(function () use ($data) {
            $lancamento = $this->getDefaultRepository()->skipPresenter(true)->where("id", $data['lancamento_id'])->first();
            // if ($data['situacao_lancamento'] == SituacaoLancamento::COMPENSACAO) {
            //     $compensado = $this->lancamentofinanceiroService->compensacao($data, $lancamento);
            //     if ($compensado instanceof \Exception) {
            //         return $compensado;
            //     }
            //     return response()->json(["Message" => "Lançamento Financeiro baixado!"], 200);
            // }
            $this->lancamentofinanceiroService->launchDown($data, $lancamento);
            $this->lancamentofinanceiroService->verifyDown($lancamento);
            $verifyParent = $this->lancamentofinanceiroService->verifyParent($lancamento);
            if ($verifyParent == SituacaoPagamento::BAIXADO) {
                return response()->json(["Message" => "Lançamento Financeiro baixado!"], 200);
            }
            $lancamentoNovo = LancamentoFinanceiro::create($lancamento->toArray());
            return self::transformerData($lancamentoNovo, ContasReceberPresenter::class);
        }, true);
    }

    public function estorno(int $id)
    {
        return $this->handleTryCatch(function () use ($id) {
            if (!isset($id)) {
                return response()->json(["Message" => "Id do lançamento não informado!"], 400);
            }
            $lancamento = $this->getDefaultRepository()->skipPresenter(true)->where("id", $id)->first();
            if (!isset($lancamento)) {
                return response()->json(["Message" => "Lançamento não encontrado!"], 400);
            }
            if ($lancamento->situacao_pagamento != SituacaoPagamento::BAIXADO) {
                return response()->json(["Message" => "Lançamento não está disponivel para esse tipo de operação!"], 200);
            }
            if (isset($lancamento->filhos)) {
                $lancamento->filhos->each(function ($filhos) {
                    $filhos->saldo += $filhos->valor_original;
                    $filhos->situacao_pagamento = SituacaoPagamento::ABERTO;
                    $filhos->historico_situacao = HistoricoSituacao::ESTORNADO;
                    $filhos->valor_pago = 0;
                    $filhos->data_baixa = null;
                    $filhos->data_pagamento = null;
                    $filhos->historico = $filhos->historico . $this->lancamentofinanceiroService->descBaixa(DescHistoricoEnum::ESTORNO);
                    $filhos->save();
                });
            }
            $lancamento->saldo += $lancamento->valor_original;
            $lancamento->situacao_pagamento = SituacaoPagamento::ABERTO;
            $lancamento->historico_situacao = HistoricoSituacao::ESTORNADO;
            $lancamento->valor_pago = 0;
            $lancamento->data_baixa = null;
            $lancamento->data_pagamento = null;
            $lancamento->historico = $lancamento->historico . $this->lancamentofinanceiroService->descBaixa(DescHistoricoEnum::ESTORNO);
            $lancamento->save();
            return self::transformerData($lancamento, ContasReceberPresenter::class);
        }, true);
    }

    public function agrupar(array $request)
    {
        return $this->handleTryCatch(function () use ($request) {
            $lancamentos = $this->getDefaultRepository()->skipPresenter(true)->findWhereIn('id', $request['agrupados']);
            $filhos = count($request['agrupados']);
            unset($request['agrupados']);
            $numero_documento = $lancamentos->venda_id ? $lancamentos->venda_id : $lancamentos->id;
            $request['num_parcela'] = ($filhos + 1);
            $numeroGerado = $numero_documento . '/' . '1-' . $filhos . 'AG';
            $request['numero_documento'] = $numeroGerado;
            $request['tipo'] = $lancamentos[0]->tipo;
            $request['saldo'] = $lancamentos->sum('saldo');
            $request['valor_original'] = $lancamentos->sum('valor_original');
            $request['tipo_parcela'] = TipoParcela::AGRUPADO;
            $request['situacao_pagamento'] = SituacaoPagamento::ABERTO;
            $mensagemDescricao = $this->lancamentofinanceiroService->descBaixa(null, DescHistoricoEnum::AGRUPADO);
            $request['descricao'] = isset($request['descricao']) ? $request['descricao'] : $mensagemDescricao;
            $request['historico'] = $mensagemDescricao;
            $newLancamento = $this->getDefaultRepository()->skipPresenter(true)->create($request);
            $lancamentos->each(function ($lancamento) use ($newLancamento, $mensagemDescricao) {
                $newLancamento->valor_original  += $lancamento->valor_original;
                $lancamento->historico = $mensagemDescricao;
                $lancamento->parent_id = $newLancamento->id;
                $lancamento->tipo_parcela = TipoParcela::AGRUPADO;
                $lancamento->save();
            });
            return transformer_data($newLancamento, ContasReceberPresenter::class);
        }, true);
    }

    public function desagrupar(mixed $request)
    {
        return $this->handleTryCatch(function () use ($request) {
            $lancamentos = $this->getDefaultRepository()->skipPresenter(true)->find($request);
            $this->lancamentofinanceiroService->childrenUp($lancamentos);
            return self::responseSuccess(self::$HTTP_CODE_OK, 'Lançamento desagrupado!');
        }, true);
    }

    public function substituicao(array $request)
    {
        return $this->handleTryCatch(function () use ($request) {
            $lancamento = $this->getDefaultRepository()->skipPresenter(true)->where('id', $request['id'])->get();
            if (isset($lancamento->parent_id)) {
                $request['parent_id'] = $lancamento->parent_id;
            }
            $request['historico'] = "Lancamento financeiro resultado de substituicao, id da antiga substituição: " + $lancamento->id;
            $newLaunch = $this->getDefaultRepository()->skipPresenter(true)->create($request);
            $lancamento->situacao_pagamento = SituacaoPagamento::BAIXADO;
            $lancamento->historico_situacao = HistoricoSituacao::SUBSTITUIDO;
            $lancamento->data_baixa = date('Y-m-d h:i:s');
            $lancamento->historico = $lancamento->historico . $this->lancamentofinanceiroService->descBaixa(null, DescHistoricoEnum::SUBSTITUICAO) . "ID do novo lancamento: " . $newLaunch->id;
            $lancamento->save();
            return self::responseSuccess(self::$HTTP_CODE_OK, 'Lançamento substituído!');
        }, true);
    }

    public function getFilhos($id, $paginacao, $request)
    {
        return $this->handleTryCatch(function () use ($id, $paginacao, $request) {
            $lancamentos = $this->getDefaultRepository()
                ->resetScope()
                ->pushCriteria(new OrderCriteria($request))
                ->scopeQuery(function ($query) use ($id) {
                    return $query->orderBy('created_at', 'desc')
                        ->where('parent_id', $id);
                })
                ->skipPresenter(true)
                ->paginate($paginacao);

            return transformer_data($lancamentos, ContasReceberPresenter::class);
        }, true);
    }

    public function update(array $data, $id): mixed
    {
        return $this->handleTryCatch(function () use ($data, $id) {

            $lancamentos = $this->getDefaultRepository()->resetScope()->skipPresenter(true)->find($id);

            if (isset($data['centro_custo'])) {
                $centro = $data['centro_custo'];
                unset($data['centro_custo']);
            }
            if (isset($centro)) {
                $lancamentos->centro_pivot()->sync($centro);
            }
            $lancamentos->fill($data);
            $lancamentos->save();
            return self::transformerData($lancamentos, ContasReceberPresenter::class);
        }, true);
    }

    public function parcelaAvulsa($request): mixed
    {
        return $this->handleTryCatch(function () use ($request) {
            $lancamento = $this->getDefaultRepository()->skipPresenter()->find($request['lancamento_id']);
            $filhosAvulsos = LancamentoFinanceiro::where('parent_id', $request['lancamento_id'])->where('tipo_parcela', TipoParcela::AVULSO)->count();
            unset($request['lancamento_id']);
            foreach ($request as $key => $value) {
                $lancamento[$key] = $value;
            }
            $lancamento->create_at = date('Y-m-d H:m:i');
            $lancamento->update_at = null;
            $lancamento->historico = $this->lancamentofinanceiroService->descBaixa(null, DescHistoricoEnum::CRIADO);
            $lancamento->total_parcelas = 0;
            $lancamento->tipo_parcela = TipoParcela::AVULSO;
            $lancamento->tipo = TipoLancamento::ENTRADA;
            $lancamento->situacao_pagamento = SituacaoPagamento::ABERTO;
            $lancamento->saldo = $lancamento->valor_original;
            $newLancamento = $this->getDefaultRepository()->skipPresenter()->create($lancamento->toArray());
            $numero_documento = $newLancamento->venda_id ? $newLancamento->venda_id : $newLancamento->id;
            $newLancamento->num_parcela = ($filhosAvulsos + 1);
            $numeroGerado = $numero_documento . '/' . ($filhosAvulsos + 1) . '-999AV';
            $newLancamento->numero_documento = $numeroGerado;
            $newLancamento->save();
            return transformer_data($newLancamento, ContasReceberPresenter::class);
        }, true);
    }
}
