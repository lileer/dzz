<?php

namespace Dzz\Http;

use Dzz\Core\Object;

class Cookie extends Object
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}