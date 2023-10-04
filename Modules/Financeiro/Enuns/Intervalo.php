<?php

namespace Modules\Financeiro\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class Intervalo extends BaseEnum
{
	use ToArray, Hydrator;

	public const DIA = 1;
	public const SEMANA = 2;
	public const MES = 3;
	public const ANO = 4;

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
		self::DIA => [self::DIA, "Dia","day"],
		self::SEMANA => [self::SEMANA, "Semanal","week"],
		self::MES => [self::MES, "Mensal","month"],
		self::ANO => [self::ANO, "Anual","year"],
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