<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/7
 * Time: 下午2:44
 */

namespace Dzz\Pipeline;

interface MiddlewareInterface
{
    public function handle($passable, $next);
}