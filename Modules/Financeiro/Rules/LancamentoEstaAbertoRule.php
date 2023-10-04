<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Financeiro\Enuns\StatusLancamento;
use Modules\Financeiro\Services\LancamentoFinanceiroService;

class LancamentoEstaAbertoRule implements Rule
{

	private $lancamento;

	private $mensagem;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->lancamento = app(LancamentoFinanceiroService::class);
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
		$lancamento = $this->lancamento->getDefaultRepository()->skipPresenter(true)->find($value);
		if($lancamento->status_lancamento != StatusLancamento::ABERTO){
			$this->mensagem = 'O lançamento nº '.$lancamento->id.' não está aberto.';
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
        return $this->mensagem;
    }
}
