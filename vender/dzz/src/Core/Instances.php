<?php

namespace Dzz\Core;

class Instances
{

    private static $objectContainer = [];

    public static function make($class, $params)
    {

        if (self::has($class)) {
            return self::$objectContainer[$class];
        } else {
            return self::$objectContainer[$class] = new $class($params);
        }
    }

    private static function has($class)
    {
        return array_key_exists($class, self::$objectContainer) ? true : false;
    }

    public static function set($class, $obj)
    {
        self::$objectContainer[$class] = $obj;
    }

    public static function get($class)
    {
        if (self::has($class)) {
            return self::$objectContainer[$class];
        }
        return false;
    }

    public static function remove($class)
    {
        unset(self::$objectContainer[$class]);
    }
}