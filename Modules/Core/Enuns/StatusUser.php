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

class StatusUser extends BaseEnum
{
	use ToArray, Hydrator;

	public const DESTAIVADO = 0;
	public const ATIVADO = 1;

	private $descricao;

	public function __construct($modulo = null)
	{
		if(!is_null($modulo)){
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::DESTAIVADO => ["Desativado"],
		self::ATIVADO => ["Ativado"],
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
