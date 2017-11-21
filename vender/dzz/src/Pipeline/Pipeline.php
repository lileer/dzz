<?php

namespace Dzz\Pipeline;

use Dzz\Core\Dzz;
use Dzz\Core\Object;

class Pipeline extends Object
{
    private $passable;
    private $middleWares = [];
    private $closures = [];
    private $first;

    public function __construct()
    {
        $this->first = function () {};
    }

    public function setFirst(\Closure $first)
    {
        $this->first = $first;
        return $this;
    }

    public function setPassable($passable)
    {
        $this->passable = $passable;
        return $this;
    }

    public function setMiddleWare($mw)
    {
        array_push($this->middleWares, $mw);
        return $this;
    }

    public function setMiddleWares($mws)
    {
        $this->middleWares = $mws;
        return $this;
    }

    private function wrap()
    {
        if (!empty($this->middleWares)) {
            foreach ($this->middleWares as $val) {
                $closure = function ($passable, $stack) use ($val) {
                    if ($val instanceof MiddlewareInterface) {
                        return $val->handle($passable, $stack);
                    } elseif ($val instanceof \Closure) {
                        call_user_func($val, $passable, $stack);
                    } elseif (is_string($val)) {
                        if (class_exists($val)) {
                            $obj = Dzz::make($val);
                            if ($obj instanceof MiddlewareInterface) {
                                $obj->handle($passable, $stack);
                            }
                        }
                    }
                };
                array_unshift($this->closures, $closure);
            }
        }
    }

    public function run()
    {
        $this->wrap();
         call_user_func(array_reduce($this->closures, function ($stack, $item) {
                return function ($passable) use ($stack, $item) {
                    if ($item instanceof \Closure) {
                        return call_user_func($item, $passable, $stack);
                    }
                    throw new \Exception('The item should is closure');
                };
        }, $this->first), $this->passable);

         return $this;
    }

//    public function after($router, $callback)
//    {
//        $self = $this;
//        $closure = function () use ($self) {
//            $this->match(function () {
//
//            });
//        };
//
//        return $closure->bindTo($router);
//    }

}