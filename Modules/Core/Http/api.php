<?php
Route::group(['prefix'=>'v1'], function () {
	\Modules\Core\Rotas\CoreRoute::run();
    \Modules\Core\Rotas\UserRoute::run();
    \Modules\Core\Rotas\FilialRoute::run();
	\Modules\Core\Rotas\AuthRoute::run();
    \Modules\Core\Rotas\PessoaRoute::run();
});
