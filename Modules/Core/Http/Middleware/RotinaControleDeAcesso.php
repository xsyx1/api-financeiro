<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Repositories\UserRepository;
use App\Traits\ResponseActions;

class RotinaControleDeAcesso
{
    use ResponseActions;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user();
        if ((int) $user->id == 1) {
            return $next($request);
        }

        if (is_null($user)) {
            return self::responseError(
                self::$HTTP_CODE_UNAUTHORIED,
                'Usuário não está autenticado!'
            );
        }

        if (!$this->userRepository->temAcessoRotina($user->id, $role)) {
            return self::responseError(
                self::$HTTP_CODE_UNAUTHORIED,
                'Você não possui permissão para acessar este recurso!'
            );
        }
        return $next($request);
    }
}
