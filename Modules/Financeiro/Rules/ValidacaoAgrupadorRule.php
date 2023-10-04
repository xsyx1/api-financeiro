<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Financeiro\Services\ContasPagarService;

class ValidacaoAgrupadorRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $contasPagarService = null)
    {
        $this->contasPagarService = App(ContasPagarService::class);
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
        $count = count($value);
        $conta = [];
        $clientes = [];
        $lancamentos = $this->contasPagarService->getDefaultRepository()->skipPresenter(true)->whereIn('id', $value)->get();
        foreach ($lancamentos as $lancamento) {
            if (isset($lancamento?->conta_financeiro_id)) {
                array_push($conta, $lancamento?->conta_financeiro_id);
            }
            if (isset($lancamento?->cliente_id)) {
                array_push($clientes, $lancamento?->cliente_id);
            }
        };
        if ($count != count($clientes)) {
            if ($count != count($conta)) {
                return false;
            }
        }

        $result_conta = array_unique($conta);
        if (!isset($result_conta)) {
            $result_clientes = array_unique($clientes);
            if (count($clientes) == 1 || count($result_clientes) != 1) {
                return false;
            }
        }
        if (count($result_conta) != 1) {
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
        return 'Ao agrupar Lançamentos Financeiros é obrigatorio que os mesmos tenham Cliente/Fornecedor iguais ou a mesma Conta Financeira';
    }
}
