<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/23
 * Time: 下午3:16
 */

namespace dzz\Core;


class Event
{

    private $handlers;

    public function attach()
    {
        $args = func_get_args();

        switch (count($args)) {
            case 1:
                if (is_callable($args[0])) {
                    $this->handlers[] = $args[0];
                }
                break;
            case 2:
                if (is_object($args[1])) {
                    $this->handlers[] = [&$args[1], $args[0]];
                } elseif (is_string($args[0]) && is_string($args[1])) {
                    $this->handlers[] = [$args[1], $args[0]];
                } else {
                    throw new \Exception("Invalid callback");
                }
                break;
            default:
                return;
        }
    }

    public function fire()
    {
        foreach ($this->handlers as $callback) {
            $args = func_get_args();
            call_user_func_array($callback, $args);
        }
    }
}