<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 17/08/2018
 * Time: 09:27
 */

namespace Modules\Core\Database\Factories;

use Faker\Generator as Faker;

class UserFactory extends BaseFactory
{
	/**
	 * @var \Illuminate\Database\Eloquent\Factory
	 */
	private $factory;

	public function __construct(\Illuminate\Database\Eloquent\Factory $factory)
	{
		$this->factory = $factory;
	}

	public static function run(){
		self::getFactory()->define(\Modules\Core\Models\User::class, function (Faker $faker) {
			return [
				'name' => 'Admin',
				'email' => 'admin@admin.com',
				'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
				'remember_token' => str_random(10),
			];
		});
		self::getFactory()->define(\Modules\Core\Models\Filial::class, function (Faker $faker) {
			return [];
		});
		self::getFactory()->define(\Modules\Core\Models\Pessoa::class, function (Faker $faker) {
			return [
				'nome' => $faker->name()
			];
		});
	}
}