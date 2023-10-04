<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 17/08/2018
 * Time: 09:45
 */

namespace Modules\Core\Database\Factories;

use Faker\Generator as Faker;

abstract class BaseFactory
{
	/**
	 * @return \Illuminate\Database\Eloquent\Factory
	 */
	public static function getFactory(){
		return app(\Illuminate\Database\Eloquent\Factory::class);
	}
}