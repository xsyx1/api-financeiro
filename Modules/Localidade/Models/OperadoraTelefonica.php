<?php


namespace Modules\Localidade\Models;


use App\Models\BaseModel;

class OperadoraTelefonica extends BaseModel
{
	protected $table = "tb_operadora_telefonia";

	public $timestamps = false;

    protected $fillable = [
		'nome',
		'codigo',
		'id_tb_emitente',
	];
}
