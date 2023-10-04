<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 12/7/2018
 * Time: 1:29 PM
 */

namespace Modules\Core\Traits;


use Illuminate\Database\Schema\Blueprint;

trait FiliaisMigrationTrait
{
		private static function insertFilialForeng(Blueprint &$table){
			$table->integer('filial_id')->unsigned()->nullable()->description('usado para agrupar os registros');
			$table->foreign('filial_id')->references('id')->on('core.filiais')->onDelete('cascade');
		}
}