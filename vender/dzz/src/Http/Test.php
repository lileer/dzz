<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/9
 * Time: 下午3:08
 */

namespace Dzz\Http;


use Dzz\Core\Object;
use Dzz\Pipeline\MiddlewareInterface;

class Test extends Object implements MiddlewareInterface
{

    public function handle($passable, $next)
    {
        if ($passable instanceof Request) {
            $passable->a++;
//            $get =$passable->getGet();
//            foreach ($get as $key => $val) {
////                $get[$key] = $val . 'xxx';
//            }
//            $passable->setGet($get);
        }
        return $next($passable);
    }

}