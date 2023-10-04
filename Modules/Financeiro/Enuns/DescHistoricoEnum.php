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

/**
 * Summary of DescHistoricoEnum
 */
class DescHistoricoEnum extends BaseEnum
{
    use ToArray, Hydrator;

    public const BAIXA_PARCIAL = 0;
    public const BAIXA_TOTAL = 1;
    public const ESTORNO = 2;
    public const COMPENSACAO = 3;
    public const PARCELADO = 4;
    public const AGRUPADO = 5;
    public const DESAGRUPADO = 6;
    public const SUBSTITUICAO = 7;
    public const CRIADO = 8;
    public const RECORREMCIA = 9;


    private $descricao;
	private $externo;
	private $id;

    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $this->id = $id;
            $this->hydrate($id);
        }
    }

    /**
     * Summary of typeLabels
     * @var array
     */
    public static $typeLabels = [
        self::BAIXA_PARCIAL => [self::BAIXA_PARCIAL, "Baixado parcialmente no dia: "],
        self::BAIXA_TOTAL => [self::BAIXA_TOTAL, "Baixado totalmente no dia: "],
        self::ESTORNO => [self::ESTORNO, "Estornado no dia: "],
        self::COMPENSACAO => [self::COMPENSACAO, "Compensado no dia: "],
        self::DESAGRUPADO => [self::DESAGRUPADO, "Deasgrupado no dia: "],
        self::AGRUPADO => [self::AGRUPADO, "Agrupado no dia: "],
        self::PARCELADO => [self::PARCELADO, "Parcelado no dia: "],
        self::SUBSTITUICAO => [self::SUBSTITUICAO, "Substituido no dia: "],
        self::CRIADO => [self::CRIADO, "Criado lancamento financeiro no dia: "],
        self::RECORREMCIA => [self::RECORREMCIA, "Recorremcia criada no dia: "]
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
				'descricao'=>$item[1],
			];
		},static::$typeLabels);
	}

    	/**
	 * @return string
	 */
	public static function getExterno($id = null)
	{
		if (!is_null($id)) {
			return self::label($id)['descricao'];
		}
	}
}
