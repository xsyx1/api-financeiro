<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Financeiro\Enuns\SituacaoLancamento;
use Modules\Financeiro\Services\LancamentoFinanceiroService;

class LancamentoBloqueadoRule implements Rule
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
		$lancamento = app(LancamentoFinanceiroService::class)->getDefaultRepository()->skipPresenter(true)->find($value);
		switch ($lancamento->situacao_lancamento){
			case SituacaoLancamento::PARCELADO:
				return false;
				break;
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
        return 'Lancamento não pode ser parcelado por que já está parceldo.';
    }
}