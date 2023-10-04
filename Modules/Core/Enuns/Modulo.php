<?php

namespace Modules\Core\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class Modulo extends BaseEnum
{
	use ToArray, Hydrator;

	public const ADMINISTRATIVO = 0;
	/*public const RH = "Recursos Humanos";
	public const COMPRAS = "Compras";
	public const CRM = "Gerenciamento de Relacionamento com o Cliente";
	public const ARQUIVO = "Arquivo";*/
	public const FINANCEIRO = 5;
	/*public const LOCACAO = "Locação";
	public const REVENDA = "Revenda";*/
	public const SAUDE = 8;
	public const ESTERILIZACAO = 9;

	private $descricao;
	private $tipo_rotina;
	private $id;
	private $modulo;

	public function __construct($modulo = null)
	{
		if(!is_null($modulo)){
			$this->modulo = $modulo;
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::ADMINISTRATIVO => ["Configuração", Rotina::class, self::ADMINISTRATIVO],
		self::SAUDE => ["Saúde", Rotina::class, self::SAUDE],
		self::FINANCEIRO => ["Financeiro", Rotina::class, self::FINANCEIRO],
		self::ESTERILIZACAO => ["Esterilização", Rotina::class, self::ESTERILIZACAO],
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
				'tipo_rotina'=>$item[1],
				'id'=>$item[2],
			];
		},static::$typeLabels);
	}
}
