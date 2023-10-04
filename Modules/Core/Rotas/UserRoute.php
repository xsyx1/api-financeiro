<?php

namespace Modules\Core\Rotas;

use App\Interfaces\ICustomRoute;
use Illuminate\Support\Facades\Route;

class UserRoute implements ICustomRoute
{
    public static function run()
    {
        Route::group(['prefix' => 'admin/core', 'middleware' => ['auth:api'], 'namespace' => 'Api\Admin'], function () {

            Route::get('user/sair', [
                'as' => 'user.sair',
                'uses' => 'UserController@logout'
            ]);

            Route::resource(
                'user',
                'UserController',
                [
                    'except' => ['create', 'edit']
                ]
            );
            Route::post('admin/core/user/autenticacao-interna', [
                'as' => 'admin.user.autenticacacao-interna',
                'uses' => 'UserController@AutenticarUsuarioInternamente',
            ]);
        });
    }
}
