<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/14
 * Time: 下午3:10
 */

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