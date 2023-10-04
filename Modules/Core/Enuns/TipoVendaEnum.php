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

class TipoVenda extends BaseEnum
{
	use ToArray, Hydrator;

    public const VENDA_PRODUTO = 0; // VENDA DE UM PRODUTO FISICO
    public const VENDA_SERVICO = 1; // VENDA DE UM SERVIÇO GENERICO
    public const VENDA_ATACADO = 2;
    public const VENDA_VAREJO = 3;
    public const IMOVEL = 4;
	public const ASSINATURA = 5;
    public const CONTRATO = 6;
	public const EXAME = 7;
	public const CONSULTA = 8;

	private $id;
	private $descricao;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::ASSINATURA => [self::ASSINATURA, "Assinaturas"],
		self::EXAME => [self::EXAME, "Exames"],
		self::CONSULTA => [self::CONSULTA, "Consultas"]
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
