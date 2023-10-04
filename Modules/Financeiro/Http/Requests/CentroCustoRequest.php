<?php

namespace Modules\Financeiro\Http\Requests;

use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class CentroCustoRequest extends BaseRequest implements ICustomRequest
{

    public function rules($id = null)
    {
		//$id = $this->getIdentificador('centrocusto');
        return [
			'nome'=>'required|string',
			'status'=>'required|boolean',
		//	'codigo' => 'unique:centro_custos,codigo'.(($id)?','.$id.',id':''),
			/*'cor'=>[
				'string',
				new HexadecimalRule()
			],*/
			/*'tipo' => [
				'required',
				new PlanoContaCheckTipo(CentroCustoService::class, $this->getField('tipo'), $this->getField('parent_id')),
				new EnumRule(TipoPlanoConta::class)
			],*/

		];
    }

    public function authorize()
    {
        return true;
    }

	public function getOnlyFields()
	{
		return [
			'nome',
			'status',
			'codigo',
			'cor',
			'recebe_lancamento',
			'tipo',
			'parent_id',
		];
	}

}
