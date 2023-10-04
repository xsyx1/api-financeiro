<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Core\Criteria\UserCriteria;
use Modules\Core\Services\UserService;
use App\Http\Controllers\BaseController;
use Modules\Core\Http\Requests\UserRequest;
use Modules\Core\Repositories\UserRepository;
use Modules\Core\Services\AuthService;
use App\Criteria\OrderCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class UserController extends BaseController
{

    private $userRepository;
    private $userService;
    public function __construct(
        UserRepository $userRepository,
        UserService $userService
    ) {
        parent::__construct($userRepository, UserCriteria::class);
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * @return UserRequest
     */
    public function getValidator()
    {
        return new UserRequest();
    }

    public function index(Request $request)
    {
        $user = AuthService::getUser();
        try {
            $paginacao = $request->get('totalitems', self::$paginationCount);
            if ($paginacao > 20) {
                $paginacao = 20;
            }
            if ($user->is_admin) {
                return $this->userService
                    ->getDefaultRepository()
                    ->resetScope()
                    ->pushCriteria(new UserCriteria($request))
                    ->pushCriteria(new OrderCriteria($request))
                    ->paginate($paginacao);
            }
            return $this->userService
                ->getDefaultRepository()
                ->pushCriteria(new UserCriteria($request))
                ->pushCriteria(new OrderCriteria($request))
                ->paginate($paginacao);
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

    public function pesquisar($query)
    {
        return $this->userService->pesquisar($query);
    }

    public function show($id)
    {
        try {
            return $this->userService
                ->getDefaultRepository()
                ->resetScope()
                ->find($id);
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
