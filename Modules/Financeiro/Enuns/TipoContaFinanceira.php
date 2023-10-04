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

class TipoContaFinanceira extends BaseEnum
{
	use ToArray, Hydrator;

	public const CONTA_CORRENTE = 0;
	public const CONTA_POUPANCA = 1;
	public const CONTA_CAIXA = 2;
	public const CONTA_COFRE = 3;

	private $id;
	private $descricao;
	private $possui_informacao_bancaria;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::CONTA_CORRENTE => [self::CONTA_CORRENTE, "Conta Corrente", true],
		self::CONTA_POUPANCA => [self::CONTA_POUPANCA, "Conta Poupança", true],
		self::CONTA_CAIXA => [self::CONTA_CAIXA, "Conta Caixa", false],
		self::CONTA_COFRE => [self::CONTA_COFRE, "Conta Cofre", false],
	];

	public static function labels()
	{
		return array_map(function ($item) {
			return [
				'id' => $item[0],
				'descricao' => $item[1],
				'possui_informacao_bancaria' => $item[2],
			];
		}, static::$typeLabels);
	}

}