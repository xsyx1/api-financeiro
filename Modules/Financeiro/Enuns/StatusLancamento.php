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

class StatusLancamento extends BaseEnum
{
	use ToArray, Hydrator;

	public const ABERTO = 0;
	public const BAIXADO = 1;
	public const SUSPENSO = 2;
    public const CANCELADO = 3;
    public const INADIMPLENTE = 3;
	public const DESTRATO = 4;

	private $id;
	private $descricao;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::ABERTO => [self::ABERTO, "Aberto"],
		self::BAIXADO => [self::BAIXADO, "Baixado"],
		self::SUSPENSO => [self::SUSPENSO, "Suspenso"],
		self::CANCELADO => [self::CANCELADO, "Cancelado"],
		self::INADIMPLENTE => [self::INADIMPLENTE, "Inadimplente"],
		self::DESTRATO => [self::DESTRATO, "Em cancelamento"],

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
