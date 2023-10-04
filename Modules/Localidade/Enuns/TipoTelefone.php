<?php

namespace Modules\Localidade\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class TipoTelefone extends BaseEnum
{
	use Hydrator, ToArray;

	public const PESSOAL = 0;
	public const RESIDENCIAL = 1;
	public const COMERCIAL = 2;
	public const RECADO = 3;

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
		self::PESSOAL => ["Pessoal", "bgm-green", self::PESSOAL],
		self::RESIDENCIAL => ["Residencial", "bgm-blue", self::RESIDENCIAL],
		self::COMERCIAL => ["Comercial", "bgm-orange", self::COMERCIAL],
		self::RECADO => ["Recado", "bgm-bluegray", self::RECADO],
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