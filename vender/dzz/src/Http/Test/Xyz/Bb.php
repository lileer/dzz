<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/13
 * Time: 下午3:01
 */

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