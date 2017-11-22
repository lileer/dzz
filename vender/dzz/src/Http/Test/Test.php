<?php

namespace Dzz\Http\Test;

class Test implements TestInterface
{

    public $test2;

    public function __construct(\Dzz\Http\Test\Test2Interface $test2)
    {
        $this->test2 = $test2;
    }

    public function handle()
    {
        $this->test2->handle();
    }
}