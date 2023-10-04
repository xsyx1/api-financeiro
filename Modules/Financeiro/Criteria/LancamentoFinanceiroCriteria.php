<?php

namespace Modules\Financeiro\Criteria;

use App\Criteria\BaseCriteria;
use Modules\Financeiro\Enuns\SituacaoPagamento;
use Modules\Financeiro\Enuns\StatusLancamento;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LancamentoFinanceiroCriteria
 * @package  Modules\Financeiro\Criteria;
 */
class LancamentoFinanceiroCriteria extends BaseCriteria
{
    protected $filterCriteria = [
		'financeiro.lancamento_financeiros.id' => '=',
		'financeiro.lancamento_financeiros.plano_conta_id' => '=',
		'financeiro.lancamento_financeiros.tipo' => 'in',
		'financeiro.lancamento_financeiros.conta_financeira_id' => '=',
		'financeiro.lancamento_financeiros.tipo_documento' => '=',
		'financeiro.lancamento_financeiros.situacao_lancamento' => '=',
		'financeiro.lancamento_financeiros.cliente_id' => '=',
		'financeiro.lancamento_financeiros.fornecedor_id' => '=',
		'financeiro.lancamento_financeiros.usuario_id' => '=',
		'financeiro.lancamento_financeiros.data_baixa' => 'between',
		'financeiro.lancamento_financeiros.data_emissao' => 'between',
		'financeiro.lancamento_financeiros.data_vencimento' => 'between',
		'core.pessoas.nome' => 'ilike',
		'core.pessoas.cpf_cnpj' => 'ilike',
	];

	public function apply($model, RepositoryInterface $repository)
	{
		$parent_id = null;
        if (isset($this->whereArray[self::FILTRO_NAME]['financeiro.lancamento_financeiros.parent_id'])) {
            $parent_id = $this->whereArray[self::FILTRO_NAME]['financeiro.lancamento_financeiros.parent_id'];
        }
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
            'core.pessoas.descricao',
            'core.pessoas.naturalidade_id',
            'core.pessoas.filiacao_pai'
        )
            ->leftJoin('financeiro.clientes', 'financeiro.lancamento_financeiros.cliente_id', '=', 'financeiro.clientes.id')
            ->leftJoin('core.pessoas', 'financeiro.clientes.pessoa_id', '=',  'core.pessoas.id')
            ->orderBy('lancamento_financeiros.data_emissao', 'DESC')
            ->where('lancamento_financeiros.situacao_pagamento', SituacaoPagamento::BAIXADO)
            ->where('lancamento_financeiros.parent_id', $parent_id);

		return $model;
	}
}