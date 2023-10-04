<?php

namespace Modules\Financeiro\Http\Requests;


use Modules\Financeiro\Enuns\StatusContaFinanceira;
use Modules\Financeiro\Enuns\TipoContaFinanceira;
use Modules\Financeiro\Traits\FilableInformacaoBancaria;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use App\Rules\EnumRule;

class ContaFinanceiroRequest extends BaseRequest implements ICustomRequest
{
	use FilableInformacaoBancaria;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules($id = null)
    {
		//$id = $this->getIdentificador('contafinanceiro');
        return [
			'nome' => 'required|string|min:1|max:255',
			'saldo' => 'nullable',
			'limite' => 'nullable',
			'dashboard' => 'boolean',
			'emite_boleto' => 'boolean',
			'informacao_bancaria_id' => 'integer|exists:informacao_bancarias,id',
			'tipo_conta' => [
				'required',
				new EnumRule(TipoContaFinanceira::class)
			],
			'status' => [
				new EnumRule(StatusContaFinanceira::class)
			],
			'informacao_bancaria' => 'required_if:tipo_conta,1|required_if:tipo_conta,0',
			'informacao_bancaria.variacao' => 'integer',
			'informacao_bancaria.nome_gerente' => 'string|min:1|max:255',
			'informacao_bancaria.telefone_contato' => 'string|min:1|max:255',
			'informacao_bancaria.desricao' => 'string|min:1|max:800',
			'informacao_bancaria.banco' => 'integer',
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
		return array_merge([
			"tipo_conta",
            "status",
            "nome",
            "saldo",
            "dashboard",
            "permitir_lanc_data_superior",
            "permitir_lanc_data_anterior",
            "descricao",
            "telefone_contato",
            "emite_boleto",
            "limite",
            "informacao_bancaria_id",
		], self::$informacaoBancariaFields);
	}
}
