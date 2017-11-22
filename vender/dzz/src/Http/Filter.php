<?php

namespace Dzz\Http;

use Dzz\Core\Object;
use Dzz\Pipeline\MiddlewareInterface;

class Filter extends Object implements MiddlewareInterface
{

    public function handle($passable, $next)
    {
        if (!get_magic_quotes_gpc()) {
            if ($passable instanceof Request) {
                $array = ['get' => $_GET, 'post' => $_POST, 'request' => $_REQUEST, 'cookie' => $_COOKIE];
                foreach ($array as $key => $val) {
                    if (!empty($val)) {
                        foreach ($val as $vkey => $vval) {
                            if (is_array($vval)) {
                                foreach ($vval as $vvkey => $vvvl) {
                                    $array[$key][$vkey][$vvkey] = addslashes($vvvl);
                                }
                            } else {
                                $array[$key][$vkey] = addslashes($vval);
                            }
                        }
                    }
                }
                $passable->setGet($array['get'])
                    ->setPost($array['post'])
                    ->setRequest($array['request'])
                    ->setCookie($array['cookie']);
            }
        }
        return $next($passable);
    }
}