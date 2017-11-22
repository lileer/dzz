<?php

namespace Dzz\Mapper\Redis;

use Dzz\Core\Object;
use Dzz\Mapper\Redis\Traits\KTrait;

class Manager extends Object
{

    use KTrait;

    public function __get($name)
    {
        if ($name == 'con') {
            return Connection::get();
        } elseif ($name == 'wcon') {
            return Connection::get(true);
        }
    }
}