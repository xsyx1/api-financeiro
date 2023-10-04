<?php


namespace Modules\Core\Models;

use Modules\Saude\Models\Representante;
use App\Models\BaseModel;

class Filial extends BaseModel
{
	protected $table = "core.filiais";

	protected $fillable = [
		'pessoa_id',
		'nome_conta',
		'valor_repasse',
		'valor_acrescimo',
		'cobra_convenio',
		'cobra_particular',
		'dia_repasse',
		'cobra_particular',
		'convenios',
		'dia_recebimento_cartao',
		'parent_id',
		'default',
		'tipo_parceria',
		'percentual_medbrasil',
		'percentual_parceria',
		'percentual_clinica',
		'percentual_medico',
		'recipient_id'
	];

	public function pessoa(){
		return $this->belongsTo(Pessoa::class, 'pessoa_id');
	}

}
