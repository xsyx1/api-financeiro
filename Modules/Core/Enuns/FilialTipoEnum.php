<?php

namespace Modules\Core\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class FilialTipoEnum extends BaseEnum
{
	use ToArray, Hydrator;

	public const MEDBRASIL = 1;
	public const PARCERIA = 2;
	public const CLINICA = 3;

	private $descricao;

	public function __construct($modulo = null)
	{
		if(!is_null($modulo)){
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::MEDBRASIL => [self::MEDBRASIL, "Medbrasil"],
		self::PARCERIA => [self::PARCERIA, "Parceira"],
		self::CLINICA => [self::CLINICA, "Clinica"],
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
