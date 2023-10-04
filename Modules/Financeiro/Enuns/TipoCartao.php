<?php

namespace Modules\Financeiro\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class TipoCartao extends BaseEnum
{
	use ToArray, Hydrator;

	public const CARTAO_CREDITO = 1;
	public const CARTAO_DEBITO = 2;
	
	private $descricao;
	private $externo;
	private $id;

	public function __construct($id = null)
	{
		if(!is_null($id)){
			$this->id = $id;
			$this->hydrate($id);
		}
	}

	protected static $typeLabels = [
		self::CARTAO_DEBITO => [self::CARTAO_DEBITO, "Cartão de Débito","debit_card"],
		self::CARTAO_CREDITO => [self::CARTAO_CREDITO, "Cartão de Crédito","credit_card"],
	];

	/**
	 * @return array
	 */
	/**
	 * @return array
	 */
	public static function labels()
	{
		return array_map(function ($item){
			return [
				'id'=>$item[0],
				'descricao'=>$item[1],
				'externo'=> $item[2],
			];
		},static::$typeLabels);
	}
	/**
	 * @return string 
	 */
	public static function getExterno($id = null)
	{
		if (!is_null($id)) {
			return self::label($id)['externo'];
		}
	}
}