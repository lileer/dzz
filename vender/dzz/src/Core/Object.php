<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/8
 * Time: 下午2:35
 */

namespace Dzz\Core;


class Object
{


    public function __construct()
    {
    }

    public static function getClass()
    {
        return get_called_class();
    }

    public static function get($params = null)
    {
        return Instances::make(self::getClass(), $params);
    }

    public function __set($name, $value)
    {

    }


}