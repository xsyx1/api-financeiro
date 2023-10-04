<?php

namespace Modules\Core\Traits;


trait FilableGrupo
{
	private static $grupoFields = [
		'grupos',
		/*'telefone.numero',
		'telefone.ddd',
		'telefone.observacoes',
		'telefone.tipo_telefone',*/
	];

	private static function rulesGrupoExtended($extend = '', $id = null)
	{
		return [
			$extend . 'grupos'=>'array',
			$extend . 'grupos.*.id' =>'required_with:grupos|integer',
		];
	}
}