<?php

namespace App\Traits;

trait Hydrator
{
	public function hydrate($id){
		$rs = self::label($id);
		if(!$rs)
			throw new \Exception('ID não encontrado');
		foreach ($rs as $key=>$val){
			$this->{$key} = $val;
		}
	}
}
