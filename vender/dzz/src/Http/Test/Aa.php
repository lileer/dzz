<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/13
 * Time: 下午3:00
 */

namespace dzz\Http\Test;


class Aa
{
    public $bb;
    public $ti;
    public $xyz;
    public function __construct(\Dzz\Http\Test\TestInterface $ti, \Dzz\Http\Test\Xyz\Bb $bb, $xyz)
    {
        $this->ti = $ti;
        $this->bb = $bb;
        $this->xyz = $xyz;
    }

    public function run()
    {
        $this->ti->handle();
    }

}