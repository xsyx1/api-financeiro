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

class TipoDocumento extends BaseEnum
{
	use ToArray, Hydrator;

	public const NOTA_FISCAL = 0;
	public const FATURA = 1;
	public const RECIBO = 2;
	public const BOLETO = 3;
	public const COMPROVANTE_DE_DESPESA = 4;
	public const COPIA_DE_CHEQUE = 5;
	public const NOTA_PRIMISSORIA = 6;
	public const TITULO_PROVISORIO = 7;
	public const RASCUNHO = 8;
	public const TRANSFERECIA = 9;
	public const ASSINATURA = 10;

	private $id;
	private $descricao;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::NOTA_FISCAL => [self::NOTA_FISCAL, "Nota Fiscal"],
		self::FATURA => [self::FATURA, "Fatura"],
		self::RECIBO => [self::RECIBO, "Recibo"],
		self::BOLETO => [self::BOLETO, "Boleto"],
		self::COMPROVANTE_DE_DESPESA => [self::COMPROVANTE_DE_DESPESA, "Comprovante de Despesa"],
		self::COPIA_DE_CHEQUE => [self::COPIA_DE_CHEQUE, "Cheque"],
		self::NOTA_PRIMISSORIA => [self::NOTA_PRIMISSORIA, "Nota Promissória"],
		self::TITULO_PROVISORIO => [self::TITULO_PROVISORIO, "Título Provisório"],
		self::RASCUNHO => [self::RASCUNHO, "Rascunho"],
		self::TRANSFERECIA => [self::TRANSFERECIA, "Transferência"],
		self::ASSINATURA => [self::ASSINATURA, "Assinatura"],
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