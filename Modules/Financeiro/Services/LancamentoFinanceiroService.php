<?php

namespace Modules\Financeiro\Services;

use App\Criteria\OrderCriteria;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Financeiro\Enuns\TipoMovimentacao;
use Modules\Financeiro\Models\LancamentoFinanceiro;
use Modules\Financeiro\Repositories\LancamentoFinanceiroRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\HandleTryCatch;
use App\Traits\ResponseActions;
use DomainException;
use Modules\Core\Services\AuthService;
use Modules\Core\Services\DBService;
use Modules\Financeiro\Criteria\LancamentoFinanceiroCriteria;
use Modules\Financeiro\Enuns\DescHistoricoEnum;
use Modules\Financeiro\Enuns\HistoricoSituacao;
use Modules\Financeiro\Enuns\SituacaoPagamento;
use Modules\Financeiro\Enuns\TipoParcela;
use Modules\Financeiro\Presenters\LancamentoFinanceiroPresenter;
use Prettus\Repository\Exceptions\RepositoryException;

class LancamentoFinanceiroService extends BaseService implements IService
{
    use ResponseActions, HandleTryCatch;


    private static $formatData = 'Y-m-d H:i:s';

    public function __construct(
        private LancamentoFinanceiroRepository $lancamentofinanceiroRepository
    ) {
    }

    public function getDefaultRepository()
    {
        return $this->lancamentofinanceiroRepository;
    }

    public function index($request, $paginacao)
    {
        return $this->handleTryCatch(function () use ($request, $paginacao) {
            $lancamento = $this->getDefaultRepository()
                ->pushCriteria(new LancamentoFinanceiroCriteria($request))
                ->pushCriteria(new OrderCriteria($request))
                ->skipPresenter(true)
                ->paginate($paginacao);

            return self::transformerData($lancamento, LancamentoFinanceiroPresenter::class);
        }, false);
    }
    public function getFilhos(int $idPai = null, bool $presenter = false, $paginacao)
    {
        return $this->getDefaultRepository()
            ->resetScope()
            ->scopeQuery(function ($query) use ($idPai) {
                return $query->orderBy('status_lancamento', 'desc')
                    ->where('parent_id', $idPai);
            })
            ->skipPresenter($presenter)
            ->paginate($paginacao);
    }

    public function ajustarVencidos()
    {
        try {
            $lancamentos = $this->getDefaultRepository()->skipPresenter(true)->scopeQuery(function ($query) {
                return $query
                    ->where('data_vencimento', '=', Carbon::now()->subDays(1)->format('Y-m-d'))
                    ->where(function ($builder) {
                        return $builder
                            ->orWhere('tipo_parcela', '<>', TipoParcela::ORDINARIA)
                            ->orWhere('situacao_pagamento', '<>', SituacaoPagamento::BAIXADO);
                    })
                    ->where(function ($builder) {
                        return $builder
                            ->orWhere('taxa_juros', '>', 0)
                            ->orWhere(function ($builder) {
                                return $builder
                                    ->where('taxa_multa', '>', 0)
                                    ->where('valor_multa', '=', 0);
                            });
                    });
            })->all();
            $lancamentos->each(function ($lancamento) {
                $lancamento->valor_multa = self::getValorMulta($lancamento);
                $lancamento->valor_juros = self::getValorJuros($lancamento);
                $lancamento->saldo = $lancamento->saldo + $lancamento->valor_multa + $lancamento->valor_juros;
                $lancamento->save();
            });
            return self::responseSuccess(self::$HTTP_CODE_OK, 'Parcelamento iniciado com sucesso!');
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', [
                'status_code' => $e->getCode(), 'message' => $e->getMessage(),
                'arquivo' => $e->getFile(),
                'linha' => $e->getLine()
            ]));
        }
    }

    private static function getValorJuros($lancamento)
    {
        $value = $lancamento->valor_juros;
        if ($lancamento->taxa_juros == 0) {
            return $value;
        }
        $data_vencimento = date_create($lancamento->data_vencimento)->format(self::$formatData);
        $qtd_dias_carencia_juros = $lancamento->qtd_dias_carencia_juros;

        if (!check_vencido($data_vencimento, $qtd_dias_carencia_juros)) {
            return $value;
        }

        $dias_vencidos = Carbon::now()->diffInDays(Carbon::createFromFormat(self::$formatData, $data_vencimento));
        $aplica_multa = $dias_vencidos - $qtd_dias_carencia_juros;

        if ($aplica_multa <= 0) {
            return $value;
        }

        return (($lancamento->taxa_juros / 100) * $lancamento->valor_original) * $aplica_multa;
    }

    private static function getValorMulta($lancamento)
    {
        $value = $lancamento->valor_multa;
        if ($lancamento->taxa_multa == 0) {
            return $value;
        }

        if ($value > 0) {
            return $value;
        }

        $data_vencimento = date_create($lancamento->data_vencimento)->format(self::$formatData);
        $qtd_dias_carencia_multa = $lancamento->qtd_dias_carencia_multa;

        if (!check_vencido($data_vencimento, $qtd_dias_carencia_multa)) {
            return $value;
        }

        $dias_vencidos = Carbon::now()->diffInDays(Carbon::createFromFormat(self::$formatData, $data_vencimento));
        $aplica_multa = $dias_vencidos - $qtd_dias_carencia_multa;

        if ($aplica_multa <= 0) {
            return $value;
        }

        return ($lancamento->taxa_multa / 100) * $lancamento->saldo;
    }


    public function parcelar(array $request)
    {
        return $this->handleTryCatch(function () use ($request) {
            $lancamento = $this->getDefaultRepository()->skipPresenter(true)->where('id', $request['lancamento_id'])->first();
            $lancamento->tipo_parcela = TipoParcela::ORDINARIA;
            $lancamento->situacao_pagamento = SituacaoPagamento::ABERTO;
            $lancamento->total_parcelas = $lancamento->num_parcela;
            $lancamento->num_parcela = null;
            $data = $lancamento->toArray();
            for ($i = 0; $i < $data['total_parcelas']; $i++) {
                $count = $i;
                $data['num_parcela'] = $count + 1;
                $data['valor_original'] = $request['content']['parcelas'][$i]['valor_original'];
                $data['saldo'] = $request['content']['parcelas'][$i]['valor_original'];
                $data['data_vencimento'] = $request['content']['parcelas'][$i]['date'];
                $data['parent_id'] = $lancamento->id;
                $data['tipo_parcela'] = TipoParcela::ORDINARIA;
                $data['situacao_pagamento'] = SituacaoPagamento::ABERTO;
                $model = LancamentoFinanceiro::create($data);
                $numero_documento = $model->venda_id ? $model->venda_id : $model->id;
                $model->numero_documento = $numero_documento . '/' . ($count < 10 ? ('00' . $count + 1) : ('0' . $count + 1))  . '-' . $data['total_parcelas'];
                $model->save();
            }
            $lancamento->save();
            return $model;
        }, true);
    }

    public function recorrencia(int $id): mixed
    {
        return $this->handleTryCatch(function () use ($id) {
            $lancamento = $this->getDefaultRepository()->skipPresenter(true)->where('id', $id)->first();
            $lancamento->situacao_pagamento = SituacaoPagamento::ABERTO;
            $lancamento->recorrente = true;
            $lancamento->historico =  $lancamento->historico . $this->descBaixa(null, DescHistoricoEnum::RECORREMCIA);
            $lancamento->save();
            return $lancamento;
        }, true);
    }

    public function generateDate(array $date): string
    {
        $dt = Carbon::now();
        if ($dt->day > $date['dia_vencimento']) {
            $dt->addMonthsWithoutOverflow(+1);
        }
        $dt->day = $date['dia_vencimento'];
        return $dt->format(self::$formatData);
    }

    public function verifyDown(Object $lancamento)
    {
        try {
            if ($lancamento->situacao_pagamento == SituacaoPagamento::BAIXADO) {
                $lancamento->data_baixa = date(self::$formatData);
                $lancamento->data_pagamento = date(self::$formatData);
                $lancamento->save();
            }
        } catch (ModelNotFoundException | RepositoryException $e) {
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }
    public function verifyParent(Object $lancamento): int
    {
        $id = $lancamento->id ?? $lancamento->parent_id;
        $parent = $this->getDefaultRepository()->skipPresenter(true)->where('id', $id)->first();
        if (!isset($parent)) {
            throw new DomainException("não foi encontrado nenhum lancamento pai");
        }
        if ($parent->saldo == 0) {
            $lancamento->data_baixa = date(self::$formatData);
            $lancamento->data_pagamento = date(self::$formatData);
            $parent->situacao_pagamento = SituacaoPagamento::BAIXADO;
            $lancamento->historico = ($lancamento->saldo > 0)
                ? $lancamento->historico .
                $this->descBaixa(DescHistoricoEnum::BAIXA_PARCIAL, DescHistoricoEnum::PARCELADO)
                : $lancamento->historico .
                $this->descBaixa(DescHistoricoEnum::BAIXA_TOTAL, DescHistoricoEnum::PARCELADO);
            $this->childrenDown($lancamento->id);
            $parent->save();
            return SituacaoPagamento::BAIXADO;
        }
        return SituacaoPagamento::ABERTO;
    }

    public function launchDown(array $data, Object $lancamento): object
    {
        try {
            foreach ($data['pagamentos'] as $pagamento) {
                if (isset($lancamento->parent_id) && $lancamento->saldo > $pagamento['valor']) {
                    return self::responseSuccess(
                        self::$HTTP_CODE_OK,
                        "O valor do pagamento não deve ser menor que o valor devedor de uma parcela!"
                    );
                }
                $lancamento->valor_pago += $pagamento['valor'];
                $lancamento->saldo -= $pagamento['valor'];
                $lancamento->situacao_pagamento = ($lancamento->saldo > 0)
                    ? SituacaoPagamento::ABERTO : SituacaoPagamento::BAIXADO;
                $lancamento->historico = ($lancamento->saldo > 0)
                    ? $lancamento->historico .
                    $this->descBaixa(DescHistoricoEnum::BAIXA_PARCIAL)
                    : $lancamento->historico .
                    $this->descBaixa(DescHistoricoEnum::BAIXA_TOTAL);

                $lancamento->save();
                if (isset($lancamento->parent_id)) {
                    $parent = $this->getDefaultRepository()->skipPresenter(true)->find($lancamento->parent_id);
                    $parent->saldo -= $pagamento['valor'];
                    $parent->save();
                }
            }
            return $lancamento;
        } catch (ModelNotFoundException | RepositoryException $e) {
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }

    public function childrenDown(int $id)
    {
        try {
            $children = LancamentoFinanceiro::where('parent_id', $id)->get();
            $children->each(function ($child) {
                $child->data_baixa = date(self::$formatData);
                $child->data_pagamento = date(self::$formatData);
                $child->saldo = 0;
                $child->situacao_pagamento = SituacaoPagamento::BAIXADO;
                $child->historico = $child->historico
                    . $this->descBaixa(DescHistoricoEnum::BAIXA_PARCIAL, DescHistoricoEnum::PARCELADO);
                $child->save();
            });
            return $children;
        } catch (ModelNotFoundException | RepositoryException $e) {
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }

    public function childrenUp(LancamentoFinanceiro $lancamento)
    {
        try {
            $lancamento->filhos->each(function ($child) {
                $child->parent_id = null;
                $child->tipo_parcela = TipoParcela::AVULSO;
                $child->historico = $this->descBaixa(null, DescHistoricoEnum::DESAGRUPADO);
                $child->save();
            });
            $lancamento->delete();
            return $lancamento;
        } catch (ModelNotFoundException | RepositoryException $e) {
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }
    public function compensacao(array $data, Object $lancamento)
    {
        try {
            $filial = AuthService::getFilial();
            if (!isset($data['pagamentos'])) {
                return self::responseSuccess(
                    self::$HTTP_CODE_OK,
                    "Dados de pagamento não informado!"
                );
            }
            if (AuthService::getFilial()->saldo_compensado < $lancamento->sum('saldo')) {
                return self::responseSuccess(
                    self::$HTTP_CODE_OK,
                    "Saldo insulficiente para liquidar o atual lançamento por compensação!"
                );
            }
            foreach ($data['pagamentos'] as $pagamento) {
                if (isset($lancamento->parent_id) && $lancamento->saldo > $pagamento['valor']) {
                    return self::responseSuccess(
                        self::$HTTP_CODE_OK,
                        "O valor do pagamento não deve ser menor que o valor devedor de uma parcela!"
                    );
                }
                $lancamento->valor_pago = $pagamento['valor'];
                $lancamento->saldo -= $pagamento['valor'];
                $lancamento->data_baixa = date(self::$formatData);
                $lancamento->data_pagamento = date(self::$formatData);
                $lancamento->situacao_pagamento = ($lancamento->saldo > 0)
                    ? SituacaoPagamento::ABERTO : SituacaoPagamento::BAIXADO;

                $lancamento->historico = ($lancamento->saldo > 0)
                    ? $lancamento->historico .
                    $this->descBaixa(DescHistoricoEnum::BAIXA_PARCIAL, DescHistoricoEnum::COMPENSACAO)
                    : $lancamento->historico .
                    $this->descBaixa(DescHistoricoEnum::BAIXA_TOTAL, DescHistoricoEnum::COMPENSACAO);

                $lancamento->save();
                $filial->saldo_compensado -= $pagamento['valor'];
                $filial->save();
                if (isset($lancamento->parent_id)) {
                    $parent = $this->getDefaultRepository()->skipPresenter(true)->find($lancamento->parent_id);
                    $parent->saldo -= $pagamento['valor'];
                    $parent->save();
                    if ($parent->saldo == 0) {
                        $this->childrenDown($parent->id);
                    }
                }
            }

            if ($lancamento->situacao_pagamento == SituacaoPagamento::ABERTO) {
                $data = $lancamento->toArray();
                $data['valor_pago'] = null;
                $data['valor_original'] = $lancamento->saldo;
                $data['data_baixa'] = null;
                $data['data_pagamento'] = null;
                $data['situacao_pagamento'] = SituacaoPagamento::ABERTO;
                $parent = $this->getDefaultRepository()->skipPresenter(true)->create($data);
                $lancamento->situacao_pagamento = SituacaoPagamento::BAIXADO;
                $lancamento->save();
                return SituacaoPagamento::ABERTO;
            }
            return SituacaoPagamento::BAIXADO;
        } catch (ModelNotFoundException | RepositoryException $e) {
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }

    public function ajustarCampos()
    {
        try {
            DBService::beginTransaction();
            $data = LancamentoFinanceiro::get();
            foreach ($data as $item) {
                switch ($item->situacao_lancamento) {
                    case 0:
                        $item->situacao_pagamento = SituacaoPagamento::ABERTO;
                        $item->tipo_parcela = TipoParcela::ORDINARIA;
                        $item->save();
                        break;
                    case 1:
                        $item->situacao_pagamento = SituacaoPagamento::BAIXADO;
                        $item->tipo_parcela = TipoParcela::ORDINARIA;
                        $item->save();
                        break;
                    case 2:
                        $item->situacao_pagamento = SituacaoPagamento::BAIXADO;
                        $item->tipo_parcela = TipoParcela::ORDINARIA;
                        $item->save();
                        break;
                    case 3:
                        $item->situacao_pagamento = SituacaoPagamento::BAIXADO;
                        $item->tipo_parcela = TipoParcela::ORDINARIA;
                        $item->save();
                        break;
                    case 4:
                        $item->situacao_pagamento = SituacaoPagamento::ABERTO;
                        $item->tipo_parcela = TipoParcela::AGRUPADO;
                        $item->save();
                        break;
                    case 5:
                        $item->situacao_pagamento = SituacaoPagamento::ABERTO;
                        $item->tipo_parcela = TipoParcela::ORDINARIA;
                        $item->save();
                        break;
                    case 6:
                        $item->situacao_pagamento = SituacaoPagamento::INADIMPLENTE;
                        $item->tipo_parcela = TipoParcela::ORDINARIA;
                        $item->save();
                        break;
                    default:
                        $item->situacao_pagamento = SituacaoPagamento::ABERTO;
                        $item->tipo_parcela = TipoParcela::ORDINARIA;
                        $item->save();
                        break;
                }
                $item->save();
            };
            DBService::commit();
        } catch (ModelNotFoundException | RepositoryException $e) {
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }

    public function descBaixa($status = null, $type = null)
    {
        $status = match ($status) {
            DescHistoricoEnum::BAIXA_PARCIAL => DescHistoricoEnum::getExterno(DescHistoricoEnum::BAIXA_PARCIAL) . date(self::$formatData) . "; <br/> ",
            DescHistoricoEnum::BAIXA_TOTAL => DescHistoricoEnum::getExterno(DescHistoricoEnum::BAIXA_TOTAL) . date(self::$formatData) . "; <br/> ",
            DescHistoricoEnum::ESTORNO => DescHistoricoEnum::getExterno(DescHistoricoEnum::ESTORNO) . date(self::$formatData) . "; <br/> ",
            default => null
        };

        $type = match ($type) {
            DescHistoricoEnum::COMPENSACAO => DescHistoricoEnum::getExterno(DescHistoricoEnum::COMPENSACAO) . date(self::$formatData) . "; <br/> ",
            DescHistoricoEnum::PARCELADO => DescHistoricoEnum::getExterno(DescHistoricoEnum::PARCELADO) . date(self::$formatData) . "; <br/> ",
            DescHistoricoEnum::AGRUPADO => DescHistoricoEnum::getExterno(DescHistoricoEnum::AGRUPADO) . date(self::$formatData) . "; <br/> ",
            DescHistoricoEnum::DESAGRUPADO => DescHistoricoEnum::getExterno(DescHistoricoEnum::DESAGRUPADO) . date(self::$formatData) . "; <br/> ",
            DescHistoricoEnum::SUBSTITUICAO => DescHistoricoEnum::getExterno(DescHistoricoEnum::SUBSTITUICAO) . date(self::$formatData) . "; <br/> ",
            DescHistoricoEnum::CRIADO => DescHistoricoEnum::getExterno(DescHistoricoEnum::CRIADO) . date(self::$formatData) . "; <br/> ",
            default => null
        };
        return $status . $type;
    }
}
