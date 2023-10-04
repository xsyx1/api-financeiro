<?php

namespace Modules\Financeiro\Models;

use Modules\Core\Enuns\Modulo;
use Modules\Core\Models\Filial;
use Modules\Core\Models\User;
use Modules\Financeiro\Enuns\SituacaoLancamento;
use Modules\Financeiro\Enuns\TipoDocumento;
use Modules\Financeiro\Enuns\TipoLancamento;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Financeiro\Enuns\HistoricoSituacao;
use Modules\Financeiro\Enuns\SituacaoContrato;
use Modules\Financeiro\Enuns\SituacaoPagamento;
use Modules\Financeiro\Enuns\StatusLancamento;
use Modules\Financeiro\Enuns\TipoParcela;

class LancamentoFinanceiro extends BaseModel
{
    use SoftDeletes;

    const BLOQUEADO = true;
    const DESBLOQUEADO = false;

    protected $fillable = [
        "parent_id",
        "plano_conta_id",
        "centro_custo_id",
        "conta_financeiro_id",
        "tipo_documento",
        "bloqueado",
        "cliente_id",
        "filial_id",
        "fornecedor_id",
        "usuario_id",
        "data_competencia",
        "data_arq_remessa",
        "data_baixa",
        "data_conciliacao",
        "data_efetivacao",
        "data_emissao",
        "data_ult_cobranca",
        "data_vencimento",
        "descricao",
        "num_parcela",
        "protocolar",
        "qtd_dias_carencia_juros",
        "qtd_dias_carencia_multa",
        "recorrente",
        "situacao_lancamento",
        "taxa_correcao_monetaria",
        "taxa_juros",
        "taxa_multa",
        "valor_original",
        "saldo",
        "valor_correcao_monetaria",
        "valor_desconto",
        "valor_juros",
        "valor_multa",
        "valor_outros",
        "valor_taxa_bancaria",
        "tipo",
        "modulo",
        "agrupados",
        'descricao_caixa',
        'historico',
        'numero_documento',
        'situacao_pagamento',
        'tipo_parcela',
        'situacao_contrato',
        'historico_situacao',
        'status_lancamento',
        'origem_lancamento',
        'data_vencimento_renegociacao',
        'data_pagamento',
        "valor_pago",
        "total_parcelas",
        "venda_id",
        "tipo_venda",
    ];

    public function getAgrupadosAttribute($value)
    {

        if (is_null($value))
            return null;

        if (!is_array($value))
            return explode(';', $value);

        return $value;
    }

    public function setAgrupadosAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['agrupados'] = implode(';', $value);
            return;
        }
        $this->attributes['agrupados'] = $value;
    }

    public function pai()
    {
        return $this->belongsTo(LancamentoFinanceiro::class, 'parent_id');
    }
    public function filhos()
    {
        return $this->hasMany(LancamentoFinanceiro::class, 'parent_id');
    }

    public function filial()
    {
        return $this->belongsTo(Filial::class, 'filial_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function cliente(){
		return $this->belongsTo(Cliente::class, 'cliente_id');
	}

    public function plano_conta()
    {
        return $this->belongsTo(PlanoConta::class, 'plano_conta_id');
    }

    public function centro_pivot() 
    {
        return $this->belongsToMany(CentroCusto::class, 'centro_custo_financeiros', 'lancamento_financeiro_id', 'centro_custo_id');
    }

    public function conta_financeiro()
    {
        return $this->belongsTo(ContaFinanceiro::class, 'conta_financeiro_id');
    }

    public function tipo_enum()
    {
        if (is_null($this->getAttribute('tipo'))) {
            return null;
        }
        return (new TipoLancamento($this->getAttribute('tipo')))->toArray();
    }

    public function situacao_lancamento_enum()
    {
        if (is_null($this->getAttribute('situacao_lancamento'))) {
            return null;
        }
        return (new SituacaoLancamento($this->getAttribute('situacao_lancamento')))->toArray();
    }

    public function tipo_documento_enum()
    {
        if (is_null($this->getAttribute('tipo_documento'))) {
            return null;
        }
        return (new TipoDocumento($this->getAttribute('tipo_documento')))->toArray();
    }

    public function modulo_enum()
    {
        if (is_null($this->getAttribute('modulo'))) {
            return null;
        }
        return (new Modulo($this->getAttribute('modulo')))->toArray();
    }

    public function status_enum()
    {
        if (is_null($this->getAttribute('status_lancamento'))) {
            return null;
        }
        return (new StatusLancamento($this->getAttribute('status_lancamento')))->toArray();
    }
    public function situacao_pagamento_enum()
    {
        if (is_null($this->getAttribute('situacao_pagamento'))) {
            return null;
        }
        return (new SituacaoPagamento($this->getAttribute('situacao_pagamento')))->toArray();
    }
    public function tipo_parcela_enum()
    {
        if (is_null($this->getAttribute('tipo_parcela'))) {
            return null;
        }
        return (new TipoParcela($this->getAttribute('tipo_parcela')))->toArray();
    }

    public function historico_situacao_enum()
    {
        if (is_null($this->getAttribute('historico_situacao'))) {
            return null;
        }
        return (new HistoricoSituacao($this->getAttribute('historico_situacao')))->toArray();
    }

    public function situacao_contrato_enum()
    {
        if (is_null($this->getAttribute('situacao_contrato'))) {
            return null;
        }
        return (new SituacaoContrato($this->getAttribute('situacao_contrato')))->toArray();
    }

    

    public function scopePerson($query)
    {
        return $query->select(
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
            ->join('financeiro.clientes', 'financeiro.clientes.id', '=', 'financeiro.lancamento_financeiros.cliente_id')
            ->join('core.pessoas', 'core.pessoas.id', '=', 'financeiro.clientes.pessoa_id');
    }
}
