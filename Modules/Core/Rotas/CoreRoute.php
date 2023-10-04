<?php

namespace Modules\Core\Rotas;

use App\Interfaces\ICustomRoute;
use Illuminate\Support\Facades\Route;

class CoreRoute implements ICustomRoute
{
    public static function run()
    {
        Route::group(['prefix' => 'admin', 'middleware' => ['auth:api'], 'namespace' => 'Api\Admin'], function () {
            Route::get('core/filial-atual', [
                'as' => 'core.filial-atual',
                'uses' => 'CoreController@filial'
            ]);
        });
    }

}
