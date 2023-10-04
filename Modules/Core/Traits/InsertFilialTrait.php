<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 12/10/2018
 * Time: 12:04 PM
 */

namespace Modules\Core\Traits;


use Modules\Core\Services\AuthService;

trait InsertFilialTrait
{
	public static function injectFilial(){
		static::creating(function ($query){
			return insertFilial($query);
		});
		static::updating(function ($query){
			return insertFilial($query);
		});
	}



}