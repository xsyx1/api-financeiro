<?php

namespace App\Enuns;

use Modules\Core\Enuns\Modulo;

abstract class BaseEnum
{
    protected static $typeLabels = [];

    public function __set($name, $value)
    {
        return $this->{$name} = $value;
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    public function __isset($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        } else {
            throw new \DomainException("Atributo não existe' $name'");
        }
    }

    /**
     * @param string $typeValue
     * @return mixed
     */
    public static function label($typeValue)
    {
        $values = static::labels();
        if (!isset($values[$typeValue])) {
            return false;
        }
        $values[$typeValue]['id'] = $typeValue;
        return $values[$typeValue];
    }

    /**
     * @return array
     */
    abstract public static function labels();

    abstract public function toArray();

    abstract public function hydrate($id);

    /**
     * @return array
     */
    public static function values()
    {
        return array_keys(static::$typeLabels);
    }

    public static function middlewareForm($middleware, $permission)
    {
        return $middleware . ":" . $permission;
    }
}
