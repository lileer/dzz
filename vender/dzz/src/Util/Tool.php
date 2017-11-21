<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/9
 * Time: 下午5:53
 */

namespace dzz\util;


class Tool
{

    public static function isDir($dir)
    {
        return is_dir($dir);
    }

    public static function isFile($file)
    {
        return is_file($file);
    }



}