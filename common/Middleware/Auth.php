<?php

namespace common\middleware;

use dzz\core\Object;
use dzz\pipeline\MiddlewareInterface;

class Auth extends Object implements MiddlewareInterface
{

    public function handle($passable, $next)
    {
        return $next($passable);
    }

}