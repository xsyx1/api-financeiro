<?php

namespace Modules\Financeiro\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class TipoPlano extends BaseEnum
{
	use ToArray, Hydrator;

	public const INDIVIDUAL = 1;
	public const FAMILIAR = 2;
	
	private $descricao;
	private $id;

	public function __construct($id = null)
	{
		if(!is_null($id)){
			$this->id = $id;
			$this->hydrate($id);
		}
	}

	protected static $typeLabels = [
		self::INDIVIDUAL => [self::INDIVIDUAL, "Individual"],
		self::FAMILIAR => [self::FAMILIAR, "Familiar"],
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
			];
		},static::$typeLabels);
	}	
}