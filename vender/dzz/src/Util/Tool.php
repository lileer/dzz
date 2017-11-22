<?php

namespace Dzz\Util;


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