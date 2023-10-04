<?php

namespace Modules\Financeiro\Enuns;

use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class Rotina extends BaseEnum
{
	use ToArray, Hydrator;

	private $id;
	private $nome;
	private $url;
	private $isMenu;
	private $modulo;
	private $rotina;

	public function __construct($rotina = null)
	{
		if (!is_null($rotina)) {
			$this->rotina = $rotina;
			$this->id = $rotina;
			$this->hydrate($rotina);
		}
	}

	//public const GERENCIAR_USUARIOS = "INDICE1";

	protected static $typeLabels = [
		//self::GERENCIAR_USUARIOS => ["Gerenciar Usuários", "gerenciar_usuarios", false, Modulo::ADMINISTRATIVO],
	];


	/**
	 * @return array
	 */
	public static function labels()
	{
		return array_map(function ($item) {
			return [
				'nome' => $item[0],
				'url' => $item[1],
				'isMenu' => $item[2],
				'modulo' => $item[3]
			];
		}, static::$typeLabels);
	}

}