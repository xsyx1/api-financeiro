<?php

namespace Modules\Core\Http\Requests;


use Modules\Core\Rules\UserFilialRole;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class AuthRequest extends BaseRequest implements ICustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules($id = null)
    {
        return [
        	'nome_conta'=>[
				'required',
				'exists:filiais,nome_conta'
			],
			'username' => [
				'required',
				'max:255',
				new UserFilialRole($this->nome_conta)
			],
			'password' => 'required|max:255',
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
			'grant_type',
			'client_id',
			'client_secret',
			'username',
			'password',
			'nome_conta',
			'scope',
		];
	}
}
