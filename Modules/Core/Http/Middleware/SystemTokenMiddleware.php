<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\SessionManager;
use App\Traits\ResponseActions;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Modules\Core\Services\AuthService;

class SystemTokenMiddleware extends StartSession
{
    use ResponseActions;

    public function __construct(SessionManager $manager)
    {
        parent::__construct($manager);
    }

    public function handle($request, Closure $next)
    {

        $token = $request->header('authorization');

        if (is_null($token)) {
            return Response::json(
                array('message' => 'Token não encontrado no header da requisição.'),
                self::$HTTP_CODE_BAD_REQUEST['status']
            );
        }
        
        $verify =AuthService::verifyApiFinanceiro($token);

        if(!$verify){
            return Response::json(
                array('message' => 'Token invalid'),
                self::$HTTP_CODE_BAD_REQUEST['status']
            );
        }
        return $next($request);
    }
}
