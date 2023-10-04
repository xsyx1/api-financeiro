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

class SituacaoLancamento extends BaseEnum
{
	use ToArray, Hydrator;

	public const ABERTO = 0;
	public const BAIXADO = 1;
	public const BAIXADO_PARCIALMENTE = 2;
	public const CONCILIADO = 3;
	public const AGRUPADO = 4;
	public const PARCELADO = 5;
	public const SUSPENSO = 6;


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
		self::BAIXADO_PARCIALMENTE => [self::BAIXADO_PARCIALMENTE, "Baixado Parcialmente"],
		self::CONCILIADO => [self::CONCILIADO, "Conciliado"],
		self::AGRUPADO => [self::AGRUPADO, "Agrupado"],
		self::PARCELADO => [self::PARCELADO, "Parcelado"],
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