<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/10/19
 * Time: 上午9:33
 */

namespace dzz\Core;


use dzz\Core\Router\Factory as RouterFactory;
use Dzz\Http\Response;

class DispatchManager
{

//    public static function bind($pipe, \Closure $callBack)
//    {
//        $router = RouterFactory::make();
//        $binded = $callBack->bindTo($router, get_class($router));
//        $closure = $pipe->getPassable();
//        Response::get($router->match($binded));
//    }
}