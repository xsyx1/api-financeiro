<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository as BasePrettus;

abstract class BaseRepository extends BasePrettus
{

    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    public function boot()
    {
        static::scopeQuery(function ($builder) {
            return $this->checkFilial($builder, $this->makeModel());
        });
    }

    public function model()
    {
        return $this->model;
    }

    function checkFilial($query, $filable)
    {
        if (in_array('filial_id', $filable->getFillable())) {
            return $query
                ->whereIn(
                    $filable->getTable() . '.filial_id',
                    [\Modules\Core\Services\AuthService::getFilialId()]
                );
        }

        return $query;
    }

    public function onlyTrashed()
    {
        return $this->parserResult($this->model->onlyTrashed()->get());
    }

    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        return parent::paginate($limit, $columns, $method);
    }
}
