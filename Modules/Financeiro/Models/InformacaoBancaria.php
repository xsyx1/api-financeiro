<?php

namespace Modules\Financeiro\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformacaoBancaria extends BaseModel
{

    use SoftDeletes;
    
	protected $fillable = [
		"variacao",
        "nome_gerente",
        "telefone_contato",
        "titular",
        "descricao",
        "banco",
        "pessoa_id",
        "digito_agencia",
        "digito_conta",
        "conta",
        "agencia",
        "numero_cartao",
		"filial_id",
	];

}
