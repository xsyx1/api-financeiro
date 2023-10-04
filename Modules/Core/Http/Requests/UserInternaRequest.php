<?php

namespace Modules\Core\Http\Requests;

use Modules\Core\Traits\FilableGrupo;
use Modules\Core\Traits\FilableUsuario;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class UserInternaRequest extends BaseRequest implements ICustomRequest
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
    	
        return [''];
    }

    public function getOnlyFields(){
		return array_merge(
			self::$usuarioFields,
            self::$grupoFields,
            [
                'grupo_validador',
                'digital',
                'pessoa_id'
            ]
        );
	}
}
