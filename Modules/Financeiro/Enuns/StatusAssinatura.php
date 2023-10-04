<?php

namespace Modules\Financeiro\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class StatusAssinatura extends BaseEnum
{
	use ToArray, Hydrator;

	public const DESATIVADO = 0;
	public const ATIVO = 1;
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
		self::DESATIVADO => [self::DESATIVADO, "Desativado"],
		self::ATIVO => [self::ATIVO, "Ativo"],
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