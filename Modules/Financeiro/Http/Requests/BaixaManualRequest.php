<?php

namespace Modules\Financeiro\Http\Requests;


use Modules\Financeiro\Enuns\TipoDocumento;
use Modules\Financeiro\Enuns\TipoLancamento;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use App\Rules\EnumRule;
use Modules\Financeiro\Enuns\TipoMovimentacao;
use Modules\Financeiro\Rules\LancamentoBaixadoRule;

class BaixaManualRequest extends BaseRequest implements ICustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules($id = null)
    {
        return [
            "lancamento_id" => [
                "required",
                'exists:lancamento_financeiros,id',
                new LancamentoBaixadoRule()
            ],
            "descricao" => "nullable|string|max:1000",
            "tipo_documento" => [
                "nullable",
                new EnumRule(TipoDocumento::class)
            ],
            "tipo" => [
                "required",
                new EnumRule(TipoLancamento::class)
            ],
            "tipo_movimentacao" => [
                "required",
                new EnumRule(TipoMovimentacao::class)
            ],
            "pagamentos.*.conta_financeiro_id" => "required|exists:conta_financeiros,id",
            "pagamentos.*.valor" => "numeric|required",
            "pagamentos.*.meio_pagamento" => "numeric|required",
            "protocolar" => 'numeric|nullable',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return  bool
     */
    public function authorize()
    {
        return true;
    }

    public function getOnlyFields()
    {
        return [
            "lancamento_id",
            "tipo_documento",
            "protocolar",
            "tipo_movimentacao",
            "tipo",
            "modulo",
            'pagamentos',
            'mudar_data_recorrencia',
			'data_vencimento_recorrencia'
        ];
    }

    public function messages()
    {
        return [
            'lancamento_id.exists' => 'Lançamento financeiro não encontrado!',
            'pagamentos.*.conta_financeiro_id.exists' => 'Conta financeira não encontrada!',
            'pagamentos.*.valor.required' => 'Valor da baixa não informado!',
            'pagamentos.*.meio_pagamento.required' => 'Meio de pagamento não informado!',
            'tipo.required' => 'Tipo de lançamento não informado!',
            'tipo_movimentacao.required' => 'Tipo de movimentação não informado!',
            'descricao.required' => 'A descrição da baixa não foi informada',
            'descricao.max:1000' => 'O tamanho maximo da descrição é de 1000 caracteres!'
        ];
    }
}
