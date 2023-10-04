<?php

namespace Modules\Core\Http\Requests;

use Modules\Core\Traits\FilableGrupo;
use Modules\Core\Traits\FilableUsuario;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class UserRequest extends BaseRequest implements ICustomRequest
{
	use FilableGrupo, FilableUsuario;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @param null $id
	 * @return array
	 */
    public function rules($id = null)
    {
    	if(is_null($id))
    		$id = $this->getIdentificador('user');
        $rules = array_merge(
        	self::rulesUsuarioExtended(null, $id),
			self::rulesGrupoExtended()
		);

        switch($_SERVER['REQUEST_METHOD']) {
            case 'POST': {
                return $rules;
            }
            case 'PUT': {
				return self::removeFields($rules, ['password']);
			}
        }
        return $rules;
    }

    public function getOnlyFields(){
		return array_merge(
			self::$usuarioFields
			, self::$grupoFields);
	}
}
