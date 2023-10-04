<?php

namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;

class HexadecimalRule implements Rule
{
	private $erro = "Numero não é um hexadecimal";
	/**
	 * @var
	 */
	private $enum;

	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct()
	{}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		return ctype_xdigit($value);
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
