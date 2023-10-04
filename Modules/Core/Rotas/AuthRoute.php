<?php

namespace Modules\Core\Rotas;

use Modules\Core\Http\Middleware\FilialSessionMiddleware;
use App\Interfaces\ICustomRoute;
use Illuminate\Support\Facades\Route;

class AuthRoute implements ICustomRoute
{
    public static function run()
    {
        Route::group(["prefix" => "admin/core/auth", "namespace" => "Api\Admin"], function () {
            Route::post('token', [
                'as' => 'auth.login',
                'uses' => 'AuthController@token'
            ])->middleware(FilialSessionMiddleware::class);
        });        
    }
}
