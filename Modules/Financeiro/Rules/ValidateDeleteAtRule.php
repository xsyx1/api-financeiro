<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidateDeleteAtRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $table){}


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' where id = ' . $value;
        $result = DB::select($sql);
        foreach($result as $table)
        {
            if (isset($table?->deleted_at) || !empty($table?->deleted_at)) {
                return false;
            }
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
        return 'Nenhum lançamento encontrado!';
    }
}
