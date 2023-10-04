<?php

namespace Modules\Core\Enuns;

use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class PessoaSexo extends BaseEnum
{
	use ToArray, Hydrator;

	public const FEMININO = 0;
	public const MASCULINO = 1;

	private $descricao;

	public function __construct($modulo = null)
	{
		if(!is_null($modulo)){
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::FEMININO => ["Feminino"],
		self::MASCULINO => ["Masculino"],
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
				'descricao'=>$item[0],
			];
		},static::$typeLabels);
	}

}
