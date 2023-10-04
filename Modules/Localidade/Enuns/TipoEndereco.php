<?php

namespace Modules\Localidade\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class TipoEndereco extends BaseEnum
{
	use Hydrator, ToArray;

	public const RESIDENCIAL = 0;
	public const COMERCIAL = 1;
	public const CONTATO = 2;
	public const COBRANCA = 3;

	private $descricao;
	private $cor;
	private $id;

	public function __construct($modulo = null)
	{
		if(!is_null($modulo)){
			$this->modulo = $modulo;
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::RESIDENCIAL => ["Residencial", "bgm-blue", self::RESIDENCIAL],
		self::COMERCIAL => ["Comercial", "bgm-orange", self::COMERCIAL],
		self::CONTATO => ["Contato", "bgm-bluegray", self::CONTATO],
		self::COBRANCA => ["Cobranca", "bgm-green", self::COBRANCA],
	];


	/**
	 * @return array
	 */
	/**
	 * @return array
	 */
	public static function labels()
	{
		return array_map(function ($item){
			return [
				'descricao'=>$item[0],
				'cor'=>$item[1],
				'id'=>$item[2],
			];
		},static::$typeLabels);
	}
}