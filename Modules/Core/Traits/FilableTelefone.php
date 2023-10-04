<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 22/02/2018
 * Time: 16:59
 */

namespace Modules\Core\Traits;


trait FilableTelefone
{
	private static $telefoneFields = [
		'telefones'
		/*'telefone.numero',
		'telefone.ddd',
		'telefone.observacoes',
		'telefone.tipo_telefone',*/
	];

	private static function rulesTelefoneExtended($extend = '', $id = null)
	{
		return [
			$extend . 'telefones' => 'array',
			$extend . 'telefones.*.ddd' => "required_with:{$extend}telefones|max:255",
			$extend . 'telefones.*.numero' => "required_with:{$extend}telefones|max:255",
			$extend . 'telefones.*.tipo_telefone' => "required_with:{$extend}telefones|integer|in:0,1,2,3",
		];
	}
}