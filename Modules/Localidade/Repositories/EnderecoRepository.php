<?php

namespace Modules\Localidade\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EnderecoRepository
 * @package namespace Modules\Localidade\Repositories;
 */
interface EnderecoRepository extends RepositoryInterface
{
	public function pesquisarByCep($cep);
}
