<?php

namespace Modules\Financeiro\Models;

use App\Models\BaseModel;

class ConfigGeralFinanceiro extends BaseModel
{
	protected $fillable = [
		"data_base", "filial_id"
	];
}