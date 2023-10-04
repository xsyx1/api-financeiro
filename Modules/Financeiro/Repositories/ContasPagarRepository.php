<?php

namespace Modules\Financeiro\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ContasPagarRepository
 * @package  Modules\Financeiro\Repositories;
 */
interface ContasPagarRepository extends RepositoryInterface
{
		public function bloquear($id);
}
