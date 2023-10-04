<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 22/02/2018
 * Time: 16:26
 */

namespace Modules\Core\Traits;


trait FilablePessoa
{
	private static $pessoaFields = [
		'pessoa.nome',
		'pessoa.email',
		'pessoa.cpf_cnpj',
		'pessoa.estado_civil',
		'pessoa.regime_uniao',
		'pessoa.data_nascimento',
		'pessoa.sexo',
		'pessoa.id',
		'pessoa.filiacao_mae',
		'pessoa.razao_social',
		'pessoa.inscricao_municipal',
		'pessoa.inscricao_estadual',
		'pessoa.data_fundacao',
		'pessoa.descricao',
		'pessoa.digital',
		'pessoa.filiacao_pai',
		'pessoa.rg',
		'pessoa.naturalidade_id',
	];
}