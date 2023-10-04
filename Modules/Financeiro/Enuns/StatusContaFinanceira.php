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

class StatusContaFinanceira extends BaseEnum
{
	use ToArray, Hydrator;

	public const INATIVO = 0;
	public const ATIVO = 1;
	public const CANCELADO = 2;

	private $id;
	private $descricao;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::INATIVO => [self::INATIVO, "Ativo"],
		self::ATIVO => [self::ATIVO, "Inativo"],
		self::CANCELADO => [self::CANCELADO, "Cancelada"],
	];

	public static function labels()
	{
		return array_map(function ($item) {
			return [
				'id' => $item[0],
				'descricao' => $item[1],
			];
		}, static::$typeLabels);
	}

}