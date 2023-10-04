<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Financeiro\Enuns\SituacaoLancamento;
use Modules\Financeiro\Services\LancamentoFinanceiroService;

class ValorPagamentoPositivoRule implements Rule
{
	/**
	 * @var
	 */
	private $idLancamento;
	/**
	 * @var
	 */
	private $message;

	/**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($idLancamento)
    {
		$this->idLancamento = $idLancamento;
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
        $lancamento = app(LancamentoFinanceiroService::class)->getDefaultRepository()->skipPresenter(true)->find($this->idLancamento);
        if(($lancamento->saldo - $value) < 0){
			$this->message = 'O valor é maior que o saldo do lançamento.';
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
        return $this->message;
    }
}
