<?php

/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 09/02/2018
 * Time: 17:01
 */

namespace Modules\Core\Services;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Enuns\PerfilGrupo;
use Modules\Core\Presenters\UserPresenter;
use Modules\Core\Repositories\FilialRepository;
use Modules\Core\Repositories\PessoaRepository;
use Modules\Core\Repositories\UserRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Exceptions\RepositoryException;

class UserService extends BaseService implements IService
{
    use ResponseActions;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PessoaRepository
     */
    private $pessoaRepository;

    /**
     * @var FilialRepository
     */
    private $filialRepository;


    public function __construct(
        UserRepository $userRepository,
        FilialRepository $filialRepository,
        PessoaRepository $pessoaRepository,

    ) {
        $this->userRepository = $userRepository;
        $this->pessoaRepository = $pessoaRepository;
        $this->filialRepository = $filialRepository;
    }

    public function getDefaultRepository()
    {
        return $this->userRepository;
    }

    public function checkFilial($user_name, $nome_conta)
    {
        $user = $this->userRepository->skipPresenter(true)->resetScope()->findByField('username', $user_name)->first();
        if ($user->status == 0) {
            return false;
        }
        if (is_null($user)) {
            return false;
        }
        if ($user->is_admin) {
            return true;
        }
        if ($user->acesso_filhos == true) {
            foreach ($user->filiais as $filial) {
                if (isset($filial->representante['0']->id)) {
                    $filialId = $filial->id;
                    $filial = $this->filialRepository->skipPresenter(true)->findByField('nome_conta', $nome_conta)->first();
                    if ($filial->parent_id == $filialId) {
                        return true;
                    }
                }
            }
        }
        return $user->filiais->where('nome_conta', $nome_conta)->count() > 0;
    }

    public function getFilialByUser($user_name, $nome_conta)
    {
        $user = $this->userRepository->skipPresenter(true)->resetScope()->findByField('username', $user_name)->first();
        if (($user->is_admin) || ($user->acesso_filhos == true)) {
            return $this->filialRepository->skipPresenter(true)->findByField('nome_conta', $nome_conta)->first();
        }
        return $user->filiais->where('nome_conta', $nome_conta)->first();
    }

    public function pesquisar($string)
    {
        try {
            return $this->userRepository->resetScope()->findByField('email', $string);
        } catch (ModelNotFoundException | RepositoryException $e) {
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }
    public function pesquisar_por_email($string)
    {
        try {
            return $this->userRepository->resetScope()->findByField('email', $string);
        } catch (ModelNotFoundException | RepositoryException $e) {
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }
    public function pesquisar_por_username($string)
    {
        try {
            return $this->userRepository->resetScope()->findByField('username', $string);
        } catch (ModelNotFoundException | RepositoryException $e) {
            return self::responseError(
                self::$HTTP_CODE_NOT_FOUND,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        } catch (\Exception $e) {
            return self::responseError(
                self::$HTTP_CODE_BAD_REQUEST,
                null,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        }
    }
}
