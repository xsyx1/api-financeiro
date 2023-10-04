<?php

namespace Modules\Localidade\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface LocalidadeRepository
 * @package namespace App\Repositories;
 */
interface LocalidadeRepository extends RepositoryInterface
{
    public function pesquisarByCep($cep);
}
