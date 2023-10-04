<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 27/02/2018
 * Time: 15:03
 */

namespace Modules\Core\Traits;


trait FilableUsuario
{
	private static $usuarioFields = [
		'id',
		'username',
		'password',
		'password_confirmation',
		'email',
		'nome',
		'cpf',
		'anexo',
		'status',
	];

	private static function rulesUsuarioExtended($extend = '', $id = null)
	{
		return [
			$extend . 'username' => 'required|string|unique:users,username'.(($id)?','.$id:''),
			$extend . 'cpf' => 'required|string',
			$extend . 'password' => 'required|AlphaNum|min:6|Confirmed',
			$extend . 'password_confirmation' => 'required_with:password',
			$extend . 'email' => 'required|email|unique:users,email'.(($id)?','.$id:''),
			$extend . 'nome' => 'required|min:2|max:255',
			$extend . 'status' => 'required',
		];
	}
}