<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 02/03/2018
 * Time: 10:33
 */

namespace Modules\Financeiro\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class Periodicidade extends BaseEnum
{
	use ToArray, Hydrator;

	public const DIARIO = 0;
	public const SEMANAL = 1;
	public const QUINZENAL = 2;
	public const MENSAL = 3;

	private $id;
	private $descricao;
	private $value;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::DIARIO => [self::DIARIO, "Diário", 1],
		self::SEMANAL => [self::SEMANAL, "Semanal", 1],
		self::QUINZENAL => [self::QUINZENAL, "Quinzenal", 15],
		self::MENSAL => [self::MENSAL, "Mensal", 1],
	];

	public static function labels()
	{
		return array_map(function ($item) {
			return [
				'id' => $item[0],
				'descricao' => $item[1],
				'value' => $item[2],
			];
		}, static::$typeLabels);
	}

}