<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 22/02/2018
 * Time: 16:32
 */

namespace Modules\Core\Traits;


trait FilableEndereco
{
	private static $enderecoFields = [
		'enderecos',
		/*'endereco.logradouro',
		'endereco.cep',
		'endereco.pivot.numero',
		'endereco.pivotcomplemento',
		'endereco.pivot.tipo_de_endereco',
		'endereco.pivot.endereco_padrao',
		'endereco.pivot.fg_ativo',
		'endereco.pivot.ponto_referencia'*/
	];

	private static function rulesEnderecoExtended($extend = '', $id = null)
	{
		return [
			$extend . 'enderecos' => 'array',
			$extend . 'enderecos.*.logradouro' => 'required|string|min:3|max:255',
			$extend . 'enderecos.*.cep' => 'required|min:3|max:50',
			$extend . 'enderecos.*.bairro.id' => 'nullable|integer|exists:bairros,id',
			$extend . 'enderecos.*.bairro.nome' => 'nullable|string|min:3|max:255',
		];
	}
}