<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 12/5/2018
 * Time: 4:32 PM
 */

namespace Modules\Core\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;

class FilialScope implements Scope
{

	/**
	 * @var Request
	 */
	private $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * Apply the scope to a given Eloquent query builder.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder $builder
	 * @param  \Illuminate\Database\Eloquent\Model $model
	 * @return void
	 */
	public function apply(Builder $builder, Model $model)
	{
		dd('scopo');
		$user = $this->request->user();

		if($user->is_admin)
			return;

		$builder->whereIn('filial_id', array_map(function ($item){
			return $item['id'];
		}, $user->filiais->toArray()));

	}
}
