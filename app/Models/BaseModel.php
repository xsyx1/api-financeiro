<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\InsertFilialTrait;
// use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as IAuditable;

class BaseModel extends Model
{
    use InsertFilialTrait;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();
        self::injectFilial();
    }

    protected static function getInstance($class)
    {
        return app($class);
    }
}
