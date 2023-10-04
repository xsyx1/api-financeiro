<?php
namespace Modules\Financeiro\Traits;

trait FilableInformacaoBancaria
{
	private static $informacaoBancariaFields = [
		'informacao_bancaria.variacao',
		'informacao_bancaria.nome_gerente',
		'informacao_bancaria.telefone_contato',
		'informacao_bancaria.descricao',
		'informacao_bancaria.banco',
		'informacao_bancaria.conta',
		'informacao_bancaria.agencia',
		'informacao_bancaria.numero_cartao',
        "informacao_bancaria.pessoa_id",
        "informacao_bancaria.digito_agencia",
        "informacao_bancaria.digito_conta",
        "informacao_bancaria.titular",
	];
}
