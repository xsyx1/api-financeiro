<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Financeiro\Models\Cliente;

class IsClienteActiveRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(){}


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cliente = Cliente::find($value);
        if ($cliente?->status == false) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Esse Cliente se encontra inativo!';
    }
}
