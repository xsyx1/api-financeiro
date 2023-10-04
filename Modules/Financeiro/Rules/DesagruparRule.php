<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Financeiro\Enuns\SituacaoLancamento;
use Modules\Financeiro\Enuns\StatusLancamento;
use Modules\Financeiro\Models\LancamentoFinanceiro;
use Modules\Financeiro\Services\ContasPagarService;

class DesagruparRule implements Rule
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
        $lancamento = LancamentoFinanceiro::where('id', $value)->first();
        if (!isset($lancamento->parent_id) && $lancamento->situacao_lancamento != SituacaoLancamento::AGRUPADO) {
            return false;
        }
        if ($lancamento->status_lancamento != StatusLancamento::ABERTO) {
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
        return 'Lançamento não está disponivel para esse tipo de operação!';
    }
}
