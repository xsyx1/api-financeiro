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

class SituacaoContrato extends BaseEnum
{
	use ToArray, Hydrator;

	public const ATIVO = 0;
	public const DISTRATO = 1;
    public const SUSPENSO = 2;
	public const CANCELADO = 3;

	private $id;
	private $descricao;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::ATIVO => [self::ATIVO, "Ativo"],
		self::DISTRATO => [self::DISTRATO, "Em Cancelamento"],
		self::SUSPENSO => [self::SUSPENSO, "Suspenso"],
		self::CANCELADO => [self::CANCELADO, "Cancelado"],
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
