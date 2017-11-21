<?php

namespace Dzz\Core;

interface FlowInterface
{
    public function run($params);
}

class Flow
{

    public $actions = [];

    public function handleBefore()
    {

    }

    public static function handleAfter()
    {

    }

    public function handle()
    {
        if (!empty($this->actions)) {

            foreach ($this->actions as $key => $val) {
                if ($val instanceof \Closure) {
                    $val();
                } elseif (is_object($val) && $val instanceof FlowInterface) {
                    $val->run();
                }

            }
        }
    }
}