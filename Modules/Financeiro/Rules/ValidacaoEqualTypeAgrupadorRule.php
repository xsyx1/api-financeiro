<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Financeiro\Services\ContasPagarService;

class ValidacaoEqualTypeAgrupadorRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $tipos = [];
        $contaService = App(ContasPagarService::class);
        $lancamentos = $contaService
            ->getDefaultRepository()
            ->skipPresenter(true)
            ->whereIn('id', $value)->get();

        foreach ($lancamentos as $lancamento) {
            array_push($tipos, (int) $lancamento->tipo);
        }

        $resultTipos = array_unique($tipos);
        if (count($resultTipos) != 1) {
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
        return 'Ao agrupar Lançamentos Financeiros é obrigatorio que todos devem ser do mesmo tipo';
    }
}
