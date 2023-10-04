<?php

namespace Modules\Financeiro\Http\Requests;


use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class TransacaoRequest extends BaseRequest implements ICustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules($id = null)
    {
		$id = $this->getIdentificador('transacao');
        return [];
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

		];
	}
}
