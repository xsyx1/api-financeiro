<?php

namespace Modules\Financeiro\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface LancamentoFinanceiroRepository
 * @package  Modules\Financeiro\Repositories;
 */
interface LancamentoFinanceiroRepository extends RepositoryInterface
{
		public function bloquear($id);
}
