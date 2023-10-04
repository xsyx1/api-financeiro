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

class HistoricoSituacao extends BaseEnum
{
	use ToArray, Hydrator;

	public const SUBSTITUIDO = 0;
	public const ESTORNADO = 1;
    public const COMPENSADO = 2;

	private $id;
	private $descricao;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::SUBSTITUIDO => [self::SUBSTITUIDO, "Substituido"],
		self::ESTORNADO => [self::ESTORNADO, "Estornado"],
		self::COMPENSADO => [self::COMPENSADO, "Compensado"],
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
