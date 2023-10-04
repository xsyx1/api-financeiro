<?php

namespace Modules\Financeiro\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class StatusAssinaturaLancamento extends BaseEnum
{
	use ToArray, Hydrator;

	public const ABERTO = 0;
	public const PAGO = 1;	
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
		self::ABERTO => [self::ABERTO, "Aberta"],
		self::PAGO => [self::PAGO, "Pago"],
		self::CANCELADO => [self::CANCELADO, "Cancelado"],
		self::SUSPENSO => [self::SUSPENSO, "Suspenso"],
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