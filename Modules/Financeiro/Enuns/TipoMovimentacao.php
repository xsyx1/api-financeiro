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

class TipoMovimentacao extends BaseEnum
{
	use ToArray, Hydrator;

	public const TRANSFERENCIA = 0;
	public const REPASSE = 1;
	public const BAIXA_PARCIAL = 2;
	public const BAIXA_TOTAL = 3;

	private $id;
	private $descricao;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::TRANSFERENCIA => [self::TRANSFERENCIA, "Transferência"],
		self::REPASSE => [self::REPASSE, "Repasse"],
		self::BAIXA_PARCIAL => [self::BAIXA_PARCIAL, "Baixa Parcial"],
		self::BAIXA_TOTAL => [self::BAIXA_TOTAL, "Baixa Total"],
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