<?php

namespace Modules\Financeiro\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class Transacao extends BaseModel
{
    use SoftDeletes;

    protected $table = "transacoes";

    protected $fillable = [
        "tid", "body", "mensagem", "tranzacaotable_id", "tranzacaotable_type", "status"
    ];
}
