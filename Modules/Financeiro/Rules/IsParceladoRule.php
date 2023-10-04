<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Modules\Financeiro\Services\ContasPagarService;

class IsParceladoRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $contasPagarService = null){$this->contasPagarService = App(ContasPagarService::class);}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $lancamento = $this->contasPagarService->getDefaultRepository()->skipPresenter(true)->where('id', $value)->first();
        $parent = $lancamento?->filhos->all() ?? [];
        $children = $lancamento?->pai ?? [];
        if ($parent !== [] || $children !== []) {
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
        return 'Esse Registro Financeiro já está vinculado a um parcelamento!';
    }
}
