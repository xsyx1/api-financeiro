<?php

namespace Modules\Financeiro\Criteria;

use App\Criteria\BaseCriteria;
use Carbon\Carbon;
use Modules\Financeiro\Enuns\StatusLancamento;
use Modules\Financeiro\Enuns\TipoLancamento;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ContasReceberCriteria
 * @package  Modules\Financeiro\Criteria;
 */
class ContasReceberCriteria extends BaseCriteria
{
    protected $filterCriteria = [
        'financeiro.lancamento_financeiros.id' => '=',
        'financeiro.lancamento_financeiros.plano_conta_id' => '=',
        'financeiro.lancamento_financeiros.tipo' => 'in',
        'financeiro.lancamento_financeiros.conta_financeira_id' => '=',
        'financeiro.lancamento_financeiros.tipo_documento' => '=',
        'financeiro.lancamento_financeiros.situacao_lancamento' => '=',
        'financeiro.lancamento_financeiros.situacao_pagamento' => '=',
        'financeiro.lancamento_financeiros.tipo_parcela' => '=',
        'financeiro.lancamento_financeiros.historico_situacao' => '=',
        'financeiro.lancamento_financeiros.situacao_contrato' => '=',
        'financeiro.lancamento_financeiros.cliente_id' => '=',
        'financeiro.lancamento_financeiros.fornecedor_id' => '=',
        'financeiro.lancamento_financeiros.usuario_id' => '=',
        'financeiro.lancamento_financeiros.data_baixa' => 'between',
        'financeiro.lancamento_financeiros.data_emissao' => 'between',
        'financeiro.lancamento_financeiros.data_vencimento' => 'between',
        'financeiro.lancamento_financeiros.status_lancamento' => '=',
        'financeiro.lancamento_financeiros.tipo_movimentacao' => '=',
        'core.pessoas.nome' => 'ilike',
        'core.pessoas.cpf_cnpj' => 'ilike',
    ];

    public function apply($model, RepositoryInterface $repository)
    {
        $model = parent::apply($model, $repository);
        $model = $model->select(
            'financeiro.lancamento_financeiros.*',
            'core.pessoas.nome',
            'core.pessoas.email',
            'core.pessoas.cpf_cnpj',
            'core.pessoas.estado_civil',
            'core.pessoas.regime_uniao',
            'core.pessoas.data_nascimento',
            'core.pessoas.sexo',
            'core.pessoas.rg',
            'core.pessoas.filiacao_mae',
            'core.pessoas.razao_social',
            'core.pessoas.inscricao_municipal',
            'core.pessoas.inscricao_estadual',
            'core.pessoas.data_fundacao',
            'core.pessoas.naturalidade_id',
            'core.pessoas.filiacao_pai'
        )
            ->leftJoin('financeiro.clientes', 'financeiro.lancamento_financeiros.cliente_id', '=', 'financeiro.clientes.id')
            ->leftJoin('core.pessoas', 'financeiro.clientes.pessoa_id', '=',  'core.pessoas.id')
            ->where('lancamento_financeiros.tipo', TipoLancamento::ENTRADA);

        if (isset($this->whereArray[self::FILTRO_NAME]['financeiro.lancamento_financeiros.parent_id'])) {
            $parent_id = $this->whereArray[self::FILTRO_NAME]['financeiro.lancamento_financeiros.parent_id'];
            $model = $model->where('lancamento_financeiros.parent_id', $parent_id);
        }
        if (
            isset($this->whereArray[self::FILTRO_NAME]['tipo_consulta'])
            && isset($this->whereArray[self::FILTRO_NAME]['data_inicial'])
            && isset($this->whereArray[self::FILTRO_NAME]['data_final'])
        ) {
            $consulta = 'lancamento_financeiros.' . $this->whereArray[self::FILTRO_NAME]['tipo_consulta'];
            $dataInicial = Carbon::parse($this->whereArray[self::FILTRO_NAME]['data_inicial'])->format('Y-m-d') . " 00:00:00";
            $dataFinal = Carbon::parse($this->whereArray[self::FILTRO_NAME]['data_final'])->format('Y-m-d') . " 23:59:59";
            $model = $model->where($consulta, '>=', $dataInicial)->where($consulta, '<=', $dataFinal);
        }

        $model = $model->whereRaw('parent_id IS NULL OR (parent_id IS NOT NULL AND (total_parcelas = 0 OR total_parcelas IS NULL) AND recorrente = false)');
        return $model;
    }
}
