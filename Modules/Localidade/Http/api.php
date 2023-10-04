<?php
Route::group(['prefix'=>'v1','middleware' => ['cors']], function () {
    \Modules\Localidade\Rotas\LocalidadeRoute::run();
});