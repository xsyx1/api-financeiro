<?php

namespace App\Interfaces;


interface ICustomRequest
{
	public function rules($id = null);

	public function getOnlyFields();
}
