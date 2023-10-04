<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\SessionManager;
use App\Traits\ResponseActions;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;

class UserContextMiddleware extends StartSession
{
    use ResponseActions;

    public function __construct(SessionManager $manager)
    {
        parent::__construct($manager);
    }

    public function handle($request, Closure $next)
    {

        $contextUser = $request->header('context_user');

        if (
            $request->route()->getName() != "auth.login"
            && !preg_match('/no_context_md/i', $request->route()->getName())
        ) {
            $contextUser = is_null($contextUser) ? $_SERVER['REDIRECT_HTTP_CONTEXT_USER'] : $contextUser;
            if (is_null($contextUser)) {
                return Response::json(
                    array('message' => 'context_user não encontrado no header da requisição.'),
                    self::$HTTP_CODE_BAD_REQUEST['status']
                );
            }
            $request->merge([
                'context_user' => Crypt::decrypt($contextUser)
            ]);
        }
        return $next($request);
    }
}
