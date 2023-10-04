<?php

namespace Modules\Financeiro\Http\Requests;


use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use Modules\Financeiro\Rules\IsClienteActiveRule;
use Modules\Financeiro\Rules\LancamentoBaixadoRule;
use Modules\Financeiro\Rules\TransfLancamentoRule;

class TransfLancamentoRequest extends BaseRequest implements ICustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules($id = null)
    {
        $id = $this->getIdentificador('lancamentofinanceiro');
        return [
            "cliente_id" => [
				'required',
				'integer',
				'exists:clientes,id',
				new IsClienteActiveRule(),
			],
            'lancamento_id' => [
				'required',
				'array'
			],
            'lancamento_id.*' => [
				'required',
				'integer',
				'exists:lancamento_financeiros,id',
				new LancamentoBaixadoRule(),
				new TransfLancamentoRule()
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
            'cliente_id',
            'lancamento_id'
        ];
    }

    public function messages()
    {
        return [
			'cliente_id.exists' => 'Cliente não encontrado!',
			'lancamento_id.exists' => 'Lançamento não encontrado!',
        ];
    }
}
