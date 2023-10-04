<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class CnpjCpfRole implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return validar_cnpj($value) || validar_cpf($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
		return "Cnpj/Cpf Invalído";
    }

	public function __toString()
	{
		return 'cpf_cnpj';
	}
}
