<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 02/03/2018
 * Time: 10:33
 */

namespace Modules\Core\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class AmbienteEnum extends BaseEnum
{
	use ToArray, Hydrator;

	public const ADMIN = 0;
	public const FRONT = 1;

	private $descricao;

	public function __construct($modulo = null)
	{
		if(!is_null($modulo)){
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::ADMIN => [self::ADMIN, "Administrativo"],
		self::FRONT => [self::FRONT, "Front"],
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
