<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Requests\AuthRequest;

class AuthController extends Controller
{

    public function getValidator()
    {
        return new AuthRequest();
    }

    public function token(AuthRequest $request)
    {
        return $this->issueToken($request, 'password');
    }

    private function issueToken(AuthRequest $request, $grant_type, $scope = '*')
    {
        $params = [
            'grant_type' => $grant_type,
            'scope' => $scope,
        ];
        $proxy = $request::create('api/v1/token', 'POST');
        $proxy->request->add(array_merge($params, $request->getOnlyDataFields()));
        return Route::dispatch($proxy);
    }
}
