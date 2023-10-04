<?php

namespace Modules\Core\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository
 * @package namespace Modules\Core\Repositories;
 */
interface UserRepository extends RepositoryInterface
{
    public function temAcessoRotina(int $userId, $rotina);

    public function ativarDesativar(int $id);

}
