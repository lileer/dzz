<?php

namespace Dzz\Http\Test\Xyz;


class Bb
{
    public $cc;
    public function __construct(\Dzz\Http\Test\Cc $cc)
    {
        $this->cc = $cc;
    }

    public function run()
    {
        $this->cc->run();
    }
}