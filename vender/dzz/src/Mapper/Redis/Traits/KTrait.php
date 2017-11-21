<?php

namespace Dzz\Mapper\Redis\Traits;

trait KTrait
{

    public function kget($key)
    {
        return $this->con->get($key);
    }

    public function kset($key, $value, $timeout = 3600)
    {
        return $this->wcon->set($key, $value, $timeout);
    }

    public function kdelete($key)
    {
        return $this->con->del($key);
    }

    public function kisExist($key)
    {
        return $this->con->exists($key);
    }



}