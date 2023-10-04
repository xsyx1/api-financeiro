<?php

namespace App\Services;

class BaseService
{
    protected static function transformerData($data, $classPresenter)
    {
        return transformer_data($data, $classPresenter);
    }
}
