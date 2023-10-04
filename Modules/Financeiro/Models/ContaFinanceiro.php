<?php

namespace Modules\Financeiro\Models;

use Modules\Financeiro\Enuns\TipoContaFinanceira;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class ContaFinanceiro extends BaseModel
{
    use SoftDeletes;
    
    protected $fillable = [
        "tipo_conta",
        "status",
        "nome",
        "saldo",
        "dashboard",
        "permitir_lanc_data_superior",
        "permitir_lanc_data_anterior",
        "descricao",
        "telefone_contato",
        "emite_boleto",
        "limite",
        "filial_id"
    ];

    protected static function boot()
    {

        parent::boot();

        static::saved(function (ContaFinanceiro $conta_financeiro) {
            if (!$conta_financeiro->tipo_conta()['data']['possui_informacao_bancaria']) {
                $conta_financeiro->informacao_bancaria()->delete();
            }
        });

        static::deleting(function (ContaFinanceiro $conta_financeiro) {
            if (!is_null($conta_financeiro->informacao_bancaria)) {
                $conta_financeiro->informacao_bancaria()->delete();
            }
        });

    }

    public function informacao_bancaria()
    {
        return $this->hasOne(InformacaoBancaria::class, 'conta_financeiro_id');
    }

    public function tipo_conta()
    {
        if (is_null($this->getAttribute('tipo_conta'))) {
            return null;
        }
        return (new TipoContaFinanceira($this->getAttribute('tipo_conta')))->toArray();
    }
}
