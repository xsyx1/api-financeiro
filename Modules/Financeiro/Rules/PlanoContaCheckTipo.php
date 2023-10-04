<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;

class PlanoContaCheckTipo implements Rule
{
	/**
	 * @var
	 */
	private $class;
	/**
	 * @var
	 */
	private $tipo;
	/**
	 * @var
	 */
	private $parentId;

	/**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($class, $tipo, $parentId = null)
    {
		$this->class = app($class);
		$this->tipo = $tipo;
		$this->parentId = $parentId;
	}


    public function passes($attribute, $value)
    {
			if(is_null($this->parentId)){
				return true;
			}
			if(!method_exists( $this->class, 'checkTipoPai')){
				throw new \Exception('Método checkTipoPai não está implementado');
			}
			return $this->class->checkTipoPai($this->parentId, $this->tipo);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O tipo selecionado não está de acordo com o do centro de custo pai';
    }
}
