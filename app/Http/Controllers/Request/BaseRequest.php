<?php

namespace App\Http\Controllers\Request;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{

    abstract public function getOnlyFields();

    public static function removeFields($data, array $remove)
    {
        return array_diff_key($data, array_flip($remove));
    }

    protected function getIdentificador($parameters)
    {
        $id = null;
        if ($this->route()) {
            $id = $this->route()->parameter($parameters);
        }

        return $id;
    }

    public function getOnlyDataFields()
    {
        $data = $this->only(static::getOnlyFields());
        if (count($data) > 0) {
            return array_filter((array) $data, fn ($item) => null !== $item);
        }
        $jsonArray = [];
        foreach (static::getOnlyFields() as $item) {
            $jsonArray[$item] = $this->json($item);
        }
        return array_filter((array) $jsonArray, fn ($item) => null !== $item);
    }

    protected function getField($key)
    {
        return isset($this->getOnlyDataFields()[$key]) ? $this->getOnlyDataFields()[$key] : null;
    }

    protected static function injectKeyDependence($fieldInject, $data)
    {
        return array_map(function ($item) use ($fieldInject) {
            return $fieldInject . $item;
        }, $data);
    }
}
