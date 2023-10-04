<?php

namespace App\Traits;

trait ToArray
{
    public function toArray()
    {
        return ['data' => get_object_vars($this)];
    }
}
