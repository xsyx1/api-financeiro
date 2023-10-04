<?php

namespace Modules\Financeiro\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class MeioPagamento extends BaseEnum
{
	use ToArray, Hydrator;

	public const CARTAO_DEBITO = 0;
	public const DINHEIRO = 1;
	public const CHEQUE = 2;
	public const TRANSFERENCIA_BANCARIA = 3;
	public const ELETRONICO_OUTROS = 4;
	public const CONVENIO = 5;
	public const COMPENSACAO = 6;
	public const DEPOSITO = 7;
	public const BOLETO = 8;
	public const COMPENSACAO_REPASSSE = 9;
	public const CARTAO_CREDITO = 10;
	public const SISTEMA = 11;
	public const PIX = 12;

	private $descricao;
	private $id;

	public function __construct($id = null)
	{
		if(!is_null($id)){
			$this->id = $id;
			$this->hydrate($id);
		}
	}

	protected static $typeLabels = [
		self::CARTAO_DEBITO => [self::CARTAO_DEBITO, "Cartão de Débito"],
		self::CARTAO_CREDITO => [self::CARTAO_CREDITO, "Cartão de Crédito"],
		self::DINHEIRO => [self::DINHEIRO, "Dinheiro"],
		self::CHEQUE => [self::CHEQUE, "Cheque"],
		self::TRANSFERENCIA_BANCARIA => [self::TRANSFERENCIA_BANCARIA, "Transferência Bancária"],
		self::ELETRONICO_OUTROS => [self::ELETRONICO_OUTROS, "Outros"],
		self::CONVENIO => [self::CONVENIO, "Convênio"],
		self::COMPENSACAO => [self::COMPENSACAO, "Compensação de Título"],
		self::DEPOSITO => [self::DEPOSITO, "Depósito"],
		self::BOLETO => [self::BOLETO, "Boleto"],
		self::COMPENSACAO_REPASSSE => [self::COMPENSACAO_REPASSSE, "Compensação no Repasse"],
		self::SISTEMA => [self::SISTEMA, "Sistema"],
		self::PIX => [self::PIX, "Pix"],
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
}