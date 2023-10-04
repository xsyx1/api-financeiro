<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 29/06/2018
 * Time: 11:56
 */
class EnumRule implements Rule
{
	private $erro = "Valor Inválído";
	/**
	 * @var
	 */
	private $enum;

	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct($enum)
	{
		//
		$this->enum = $enum;
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		if(!class_exists($this->enum)) {
			$this->erro = "Classe e enum não existe";
			return false;
		}

		try{
			(new $this->enum($value))->toArray();
			return true;
		}catch (\Exception $e){
			return false;
		}

	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		return $this->erro;
	}
}
