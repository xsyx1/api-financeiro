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

class TipoParcela extends BaseEnum
{
	use ToArray, Hydrator;

	public const ORDINARIA = 0;
    public const AVULSO = 1;
	public const AGRUPADO = 2;


	private $id;
	private $descricao;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::ORDINARIA => [self::ORDINARIA, "Ordinaria"],
		self::AGRUPADO => [self::AGRUPADO, "Agrupado"],
		self::AVULSO => [self::AVULSO, "Lançamento avulso"],

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
