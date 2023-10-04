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

class Indice extends BaseEnum
{
	use ToArray, Hydrator;

	public const IGPM = 0;

	private $id;
	private $nome;
	private $descricao;
	private $link_curl;

	public function __construct($modulo = null)
	{
		if(!is_null($modulo)){
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		[self::IGPM, "IGPM", "ÍNDICE GERAL DE PREÇOS DO MERCADO", "http://www.portalbrasil.net/igpm.htm"],
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
				'id'=>$item[0],
				'nome'=>$item[1],
				'descricao'=>$item[2],
				'link_curl'=>$item[3],
			];
		},static::$typeLabels);
	}

}