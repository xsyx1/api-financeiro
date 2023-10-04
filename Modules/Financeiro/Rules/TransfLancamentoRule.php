<?php

namespace Modules\Financeiro\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Financeiro\Services\ContasPagarService;

class TransfLancamentoRule implements Rule
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
        $lancamento = $this->contasPagarService->getDefaultRepository()->skipPresenter(true)->where('parent_id', $value)->get();
        if (isset($lancamento)) {
            foreach ($lancamento as $filho) {
                if (strtotime($filho->data_vencimento) < strtotime(date('Y-m-d H:i:s'))) {
                    return false;
                }
            };
        }else {
            $lancamento = $this->contasPagarService->getDefaultRepository()->skipPresenter(true)->where('id', $value)->first();
            if (strtotime($lancamento->data_vencimento) > strtotime(date('Y-m-d H:i:s'))) {
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
        return 'Esse Registro Financeiro se encontra vencido e por isso não pode ser transferido!';
    }
}
