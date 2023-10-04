<?php

namespace Modules\Financeiro\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class TipoPlanoPagamento extends BaseEnum
{
	use ToArray, Hydrator;

	public const PAGO = 1;
	public const GRATUITO = 2;

	private $descricao;
	private $id;
	private $tipo_aol;

	public function __construct($id = null)
	{
		if (!is_null($id)) {
			$this->id = $id;
			$this->hydrate($id);
		}
	}

	protected static $typeLabels = [
		self::PAGO => [self::PAGO, "Pagos", 2610],
		self::GRATUITO => [self::GRATUITO, "Gratuitos", 2609],
	];

	/**
	 * @return array
	 */
	/**
	 * @return array
	 */
	public static function labels()
	{
		return array_map(function ($item) {
			return [
				'id' => $item[0],
				'descricao' => $item[1],
				'tipo_aol' => $item[2]
			];
		}, static::$typeLabels);
	}
	/**
	 * @return string 
	 */
	public static function getCodigoAol($id = null)
	{
		if (!is_null($id)) {
			return self::label($id)['tipo_aol'];
		}
	}
}
