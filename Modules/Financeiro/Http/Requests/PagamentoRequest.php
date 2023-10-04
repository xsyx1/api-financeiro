<?php

namespace Modules\Financeiro\Http\Requests;


use Modules\Financeiro\Enuns\MeioPagamento;
use Modules\Financeiro\Enuns\TipoLancamento;
use Modules\Financeiro\Rules\ValorPagamentoPositivoRule;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use App\Rules\EnumRule;

class PagamentoRequest extends BaseRequest implements ICustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules($id = null)
    {
		$id = $this->getIdentificador('id');
        return [
        	'pagamentos.*.valor' => [
        		'required',
				'numeric',
				'min:0',
				new ValorPagamentoPositivoRule($id)
			],
			"conta_financeiro_id" => "required|exists:conta_financeiros,id",
			'tipo' => [
				'required',
				new EnumRule(TipoLancamento::class)
			],
            'pagamentos.*.protocolar'=>'boolean',
			// 'pagamentos.tipo_movimentacao' => [
        	// 	'required',
			// 	new EnumRule(TipoMovimentacao::class)
			// ],
			'pagamentos.*.meio_pagamento' =>[
				'required',
				new EnumRule(MeioPagamento::class)
			]
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
			'id',
			'valor',
			'conta_financeiro_id',
			'meio_pagamento',
			'protocolar',
			'tipo',
			'pagamentos',
            'protocolar',
            'plano_conta_id',
            'centro_custo_id',
            'conta_financeiro_id',
		];
	}
}
